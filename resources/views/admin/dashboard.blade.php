<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Village Web Security</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 px-4 py-6">
            <h2 class="text-xl font-bold mb-8">🔒 Security Admin</h2>
            <nav>
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Security Dashboard</a></li>
                    <li><a href="{{ route('admin.security.index') }}" class="block p-2 rounded hover:bg-gray-700">Security Monitor</a></li>
                    <li><a href="{{ route('admin.system.info') }}" class="block p-2 rounded hover:bg-gray-700">System Info</a></li>
                    <li><a href="{{ route('admin.config.security') }}" class="block p-2 rounded hover:bg-gray-700">Security Config</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Security Dashboard</h1>

            <!-- Security Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" x-data="securityStats()">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Blocked IPs</h3>
                    <p class="text-2xl font-bold text-red-600" x-text="stats.blocked_ips">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">XSS Attempts</h3>
                    <p class="text-2xl font-bold text-orange-600" x-text="stats.xss_attempts">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">SQL Injection</h3>
                    <p class="text-2xl font-bold text-red-700" x-text="stats.sql_injection_attempts">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Brute Force</h3>
                    <p class="text-2xl font-bold text-yellow-600" x-text="stats.brute_force_attempts">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">DDoS Attempts</h3>
                    <p class="text-2xl font-bold text-purple-600" x-text="stats.ddos_attempts">0</p>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-lg shadow p-6 mb-8" x-data="systemInfo()">
                <h2 class="text-xl font-bold mb-4">System Status</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-semibold mb-2">Server Information</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>PHP Version: <span x-text="info.php_version" class="font-mono">-</span></li>
                            <li>Laravel Version: <span x-text="info.laravel_version" class="font-mono">-</span></li>
                            <li>Environment: <span x-text="info.app_env" class="font-mono">-</span></li>
                            <li>Server Time: <span x-text="info.server_time" class="font-mono">-</span></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Security Features</h3>
                        <div class="space-y-1">
                            <template x-for="[feature, enabled] in Object.entries(info.security_features || {})" :key="feature">
                                <div class="flex items-center">
                                    <span :class="enabled ? 'text-green-500' : 'text-red-500'" x-text="enabled ? '✓' : '✗'"></span>
                                    <span class="ml-2 text-sm" x-text="feature.replace(/_/g, ' ').toUpperCase()"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Security Actions</h3>
                    <div class="space-y-2">
                        <button onclick="clearSecurityCache()" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                            Clear Security Cache
                        </button>
                        <button onclick="viewSecurityLogs()" class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                            View Security Logs
                        </button>
                        <button onclick="viewBannedIPs()" class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">
                            View Banned IPs
                        </button>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Quick Stats</h3>
                    <div class="text-sm text-gray-600">
                        <p>Your IP: <span class="font-mono">{{ request()->ip() }}</span></p>
                        <p>User Agent: <span class="font-mono text-xs">{{ request()->userAgent() }}</span></p>
                        <p>Last Login: <span class="font-mono">{{ now()->format('Y-m-d H:i:s') }}</span></p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Navigation</h3>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="block text-blue-600 hover:underline">← Back to Website</a>
                        <a href="{{ route('admin.security.index') }}" class="block text-blue-600 hover:underline">Security Monitor</a>
                        <a href="/admin/security/logs" target="_blank" class="block text-blue-600 hover:underline">Raw Security Logs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function securityStats() {
            return {
                stats: {},
                async init() {
                    try {
                        // In a real app, this would be an API endpoint
                        this.stats = {
                            blocked_ips: 0,
                            xss_attempts: 0,
                            sql_injection_attempts: 0,
                            brute_force_attempts: 0,
                            ddos_attempts: 0
                        };
                    } catch (error) {
                        console.error('Failed to load security stats:', error);
                    }
                }
            }
        }

        function systemInfo() {
            return {
                info: {},
                async init() {
                    try {
                        const response = await fetch('{{ route("admin.system.info") }}');
                        this.info = await response.json();
                    } catch (error) {
                        console.error('Failed to load system info:', error);
                    }
                }
            }
        }

        function clearSecurityCache() {
            if (confirm('Are you sure you want to clear the security cache?')) {
                alert('Security cache would be cleared (implement backend endpoint)');
            }
        }

        function viewSecurityLogs() {
            window.open('{{ route("admin.security.logs") }}', '_blank');
        }

        function viewBannedIPs() {
            fetch('{{ route("admin.security.banned-ips") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.banned_ips.length === 0) {
                        alert('No banned IPs currently');
                    } else {
                        const ips = data.banned_ips.map(item => `${item.ip} (expires: ${item.expires_in})`).join('\n');
                        alert('Banned IPs:\n' + ips);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load banned IPs');
                });
        }
    </script>
</body>
</html>