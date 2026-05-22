<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InvitationController extends Controller
{
    private function companyId(): int
    {
        return session('company_id');
    }

    public function index()
    {
        $companyId = $this->companyId();

        $pending = Invitation::with('role')
            ->forCompany($companyId)
            ->where('status', 'pending')
            ->latest()
            ->get();

        $registered = User::with('roles')
            ->whereHas(
                'invitations',
                fn($q) =>
                $q->where('company_id', $companyId)->where('status', 'accepted')
            )
            ->select('id', 'name', 'email', 'status', 'last_login_at', 'created_at')
            ->latest()
            ->get();

        $roles = Role::where('company_id', $companyId)
            ->orWhereNull('company_id')  // global roles
            ->get();

        return view('company.users.index', compact('pending', 'registered', 'roles'));
    }

    // POST /company/invitations
    public function store(Request $request)
    {
        $companyId = $this->companyId();

        $request->validate([
            'email' => 'required|email|max:255',
            'role_id' => 'required|exists:roles,id',
            'name' => 'nullable|string|max:255',
        ]);

        // Already a registered user in this company?
        $alreadyUser = User::where('email', $request->email)
            ->whereHas(
                'invitations',
                fn($q) =>
                $q->where('company_id', $companyId)->where('status', 'accepted')
            )->exists();

        if ($alreadyUser) {
            return back()->with('error', 'This user already belongs to your company.');
        }

        // Upsert: re-invite if previously cancelled/expired
        $invitation = Invitation::updateOrCreate(
            ['company_id' => $companyId, 'email' => $request->email],
            [
                'invited_by' => auth()->id(),
                'role_id' => $request->role_id,
                'name' => $request->name,
                'token' => Invitation::generateToken(),
                'status' => 'pending',
                'expires_at' => now()->addDays(7),
                'last_sent_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return back()->with('success', 'Invitation sent to ' . $request->email);
    }

    // POST /company/invitations/{invitation}/resend
    public function resend(Invitation $invitation)
    {
        $this->authorizeInvitation($invitation);

        $invitation->refreshToken();

        Mail::to($invitation->email)->send(new InvitationMail($invitation));

        return back()->with('success', 'Invitation resent to ' . $invitation->email);
    }

    // DELETE /company/invitations/{invitation}
    public function cancel(Invitation $invitation)
    {
        $this->authorizeInvitation($invitation);

        $invitation->update(['status' => 'cancelled']);

        return back()->with('success', 'Invitation cancelled.');
    }

    // PUT /company/invitations/{invitation}/role
    public function assignRole(Request $request, Invitation $invitation)
    {
        $this->authorizeInvitation($invitation);

        $request->validate(['role_id' => 'required|exists:roles,id']);

        $invitation->update(['role_id' => $request->role_id]);

        // If already accepted, update the live user role too
        if ($invitation->user_id) {
            $user = User::findOrFail($invitation->user_id);
            $newRole = Role::findOrFail($request->role_id);
            $companyId = $this->companyId();

            setPermissionsTeamId($companyId);
            $user->syncRoles([$newRole]);
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        }

        return response()->json(['message' => 'Role updated.']);
    }

    // GET /company/invitations/accept/{token}  (public — no auth)
    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return view('company.users.register', compact('invitation'));
    }

    // POST /company/invitations/accept/{token}
    public function completeRegistration(Request $request, string $token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request, $invitation) {
            $user = User::create([
                'name' => $request->name,
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
                'status' => 'active',
            ]);

            setPermissionsTeamId($invitation->company_id);

            if ($invitation->role) {
                $user->assignRole($invitation->role);
            }

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            $invitation->markAccepted($user);
        });

        return redirect()->route('login')
            ->with('success', 'Registration complete! You can now log in.');
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function authorizeInvitation(Invitation $invitation): void
    {
        abort_if(
            $invitation->company_id !== $this->companyId(),
            403,
            'This invitation does not belong to your company.'
        );
    }
}