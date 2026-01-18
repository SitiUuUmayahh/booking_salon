@php
    $users = \App\Models\User::all();
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Debug Users</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .admin { background-color: #e8f5e8; }
        .user { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Debug: Semua Users di Database</h2>
    <p>Total users: {{ $users->count() }}</p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="{{ $user->role }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><strong>{{ strtoupper($user->role) }}</strong></td>
                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>Admin Users:</h3>
    @php
        $admins = $users->where('role', 'admin');
    @endphp
    
    @if($admins->count() > 0)
        <ul>
            @foreach($admins as $admin)
                <li>{{ $admin->name }} ({{ $admin->email }})</li>
            @endforeach
        </ul>
        
        <div style="background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h4>Kredensial Admin untuk Login:</h4>
            <p><strong>Email:</strong> admin@dsisisalon.com</p>
            <p><strong>Password:</strong> admin123</p>
        </div>
    @else
        <p style="color: red;">❌ Tidak ada admin user!</p>
    @endif
    
    <hr>
    <a href="{{ route('login') }}">← Kembali ke Login</a>
</body>
</html>