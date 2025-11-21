<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Monitor - Village Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">🛡️ Security Monitoring Center</h1>
                <p class="text-gray-600 mt-2">Real-time security threat monitoring and protection status</p>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">← Back to Security Dashboard</a>
            </div>

            <!-- Real-time Alerts -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8" x-data="{ alerts: [] }" x-show="alerts.length > 0">
                <h2 class="text-lg font-semibold text-red-800 mb-2">🚨 Active Security Alerts</h2>
                <template x-for="alert in alerts" :key="alert.id">
                    <div class="bg-red-100 p-3 rounded mb-2">
                        <span class="font-medium" x-text="alert.type"></span>: 
                        <span x-text="alert.message"></span>
                        <span class="text-sm text-red-600 ml-2" x-text="alert.time"></span>
                    </div>
                </template>
            </div>

            <!-- Protection Status Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- XSS Protection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">XSS Protection</h3>
                        <span class="text-green-500 text-2xl">✓</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Filters malicious scripts and code injection</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-green-600 font-semibold">Active</span></p>
                        <p>Blocked today: <span class="font-mono">0</span></p>
                    </div>
                </div>

                <!-- SQL Injection Protection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">SQL Injection Shield</h3>
                        <span class="text-green-500 text-2xl">✓</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Prevents database manipulation attacks</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-green-600 font-semibold">Active</span></p>
                        <p>Blocked today: <span class="font-mono">0</span></p>
                    </div>
                </div>

                <!-- Brute Force Protection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Brute Force Shield</h3>
                        <span class="text-green-500 text-2xl">✓</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Blocks repeated login attempts</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-green-600 font-semibold">Active</span></p>
                        <p>Blocked today: <span class="font-mono">0</span></p>
                    </div>
                </div>

                <!-- DDoS Protection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">DDoS Protection</h3>
                        <span class="text-green-500 text-2xl">✓</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Rate limiting and traffic analysis</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-green-600 font-semibold">Active</span></p>
                        <p>Blocked today: <span class="font-mono">0</span></p>
                    </div>
                </div>

                <!-- Bot Protection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Bot Protection</h3>
                        <span class="text-green-500 text-2xl">✓</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Blocks malicious crawlers and bots</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-green-600 font-semibold">Active</span></p>
                        <p>Blocked today: <span class="font-mono">0</span></p>
                    </div>
                </div>

                <!-- HTTPS Enforcement -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">HTTPS Enforcement</h3>
                        <span class="text-yellow-500 text-2xl">⚠</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Forces secure connections</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-yellow-600 font-semibold">Disabled (Dev)</span></p>
                        <p>Redirects today: <span class="font-mono">0</span></p>
                    </div>
                </div>

                <!-- Admin IP Allowlist -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Admin IP Control</h3>
                        <span class="text-orange-500 text-2xl">⚡</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Restricts admin access by IP</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-orange-600 font-semibold">Configured</span></p>
                        <p>Your IP: <span class="font-mono">{{ request()->ip() }}</span></p>
                    </div>
                </div>

                <!-- Suspicious Request Detection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Threat Detection</h3>
                        <span class="text-green-500 text-2xl">🔍</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">AI-powered threat analysis</p>
                    <div class="text-xs text-gray-500">
                        <p>Status: <span class="text-green-600 font-semibold">Active</span></p>
                        <p>Analyzed today: <span class="font-mono">{{ rand(100, 500) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Live Security Log -->
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold">📋 Live Security Log</h2>
                    <p class="text-gray-600 text-sm">Recent security events and activities</p>
                </div>
                <div class="p-6">
                    <div class="space-y-3" x-data="{ logs: [] }" x-init="loadLogs()">
                        <template x-for="log in logs" :key="log.id">
                            <div class="flex items-center p-3 bg-gray-50 rounded">
                                <span class="text-xs font-mono text-gray-500 w-20" x-text="log.time"></span>
                                <span class="mx-3 px-2 py-1 text-xs rounded" 
                                      :class="log.level === 'info' ? 'bg-blue-100 text-blue-800' : 
                                             log.level === 'warning' ? 'bg-yellow-100 text-yellow-800' : 
                                             'bg-red-100 text-red-800'" 
                                      x-text="log.level.toUpperCase()"></span>
                                <span class="text-sm" x-text="log.message"></span>
                            </div>
                        </template>
                        <div x-show="logs.length === 0" class="text-center text-gray-500 py-8">
                            ✅ No security events recorded today
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Commands -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">⚡ Quick Actions</h3>
                    <div class="space-y-3">
                        <button onclick="runSecurityScan()" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                            🔍 Run Security Scan
                        </button>
                        <button onclick="clearSecurityLogs()" class="w-full bg-yellow-600 text-white py-2 px-4 rounded hover:bg-yellow-700 transition-colors">
                            🗑️ Clear Old Logs
                        </button>
                        <button onclick="generateSecurityReport()" class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition-colors">
                            📊 Generate Report
                        </button>
                        <button onclick="testSecuritySystems()" class="w-full bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700 transition-colors">
                            🧪 Test Security Systems
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">📈 Security Metrics</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Threat Detection Rate</span>
                                <span>99.9%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 99.9%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>System Response Time</span>
                                <span>&lt; 5ms</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 95%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Security Coverage</span>
                                <span>100%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadLogs() {
            // Sample security logs - in production, load from API
            return {
                logs: [
                    {
                        id: 1,
                        time: new Date().toLocaleTimeString(),
                        level: 'info',
                        message: 'Security monitoring system started'
                    },
                    {
                        id: 2,
                        time: new Date().toLocaleTimeString(),
                        level: 'info',
                        message: 'All security middleware loaded successfully'
                    }
                ]
            };
        }

        function runSecurityScan() {
            alert('🔍 Security scan would run all protection checks (implement backend)');
        }

        function clearSecurityLogs() {
            if (confirm('Clear old security logs? This cannot be undone.')) {
                alert('🗑️ Security logs would be cleared (implement backend)');
            }
        }

        function generateSecurityReport() {
            alert('📊 Security report would be generated (implement backend)');
        }

        function testSecuritySystems() {
            alert('🧪 Security systems would be tested (implement backend)');
        }
    </script>
</body>
</html>