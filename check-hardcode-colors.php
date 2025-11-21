#!/usr/bin/env php
<?php

/**
 * Script untuk mencari hardcode colors di template files
 * Usage: php check-hardcode-colors.php
 */

echo "🔍 Checking for hardcode colors in frontend templates...\n";
echo "======================================================\n\n";

$hardcodePatterns = [
    'bg-blue-' => 'Background blue classes',
    'bg-green-' => 'Background green classes', 
    'bg-red-' => 'Background red classes',
    'bg-yellow-' => 'Background yellow classes',
    'bg-purple-' => 'Background purple classes',
    'bg-pink-' => 'Background pink classes',
    'bg-indigo-' => 'Background indigo classes',
    'text-blue-' => 'Text blue classes',
    'text-green-' => 'Text green classes',
    'text-red-' => 'Text red classes',
    'text-yellow-' => 'Text yellow classes',
    'text-purple-' => 'Text purple classes',
    'text-pink-' => 'Text pink classes',
    'text-indigo-' => 'Text indigo classes',
    'text-gray-900' => 'Dark gray text',
    'text-gray-800' => 'Dark gray text',
    'bg-gray-900' => 'Dark gray background',
    'bg-gray-800' => 'Dark gray background',
];

$excludePatterns = [
    'bg-white',
    'text-white',
    'bg-gray-50',
    'bg-gray-100',
    'bg-gray-200',
    'text-gray-400',
    'text-gray-500',
    'text-gray-600'
];

function scanDirectory($dir, $patterns, $excludePatterns) {
    $results = [];
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $lines = explode("\n", $content);
            
            foreach ($lines as $lineNumber => $line) {
                foreach ($patterns as $pattern => $description) {
                    if (strpos($line, $pattern) !== false) {
                        // Check if it should be excluded
                        $shouldExclude = false;
                        foreach ($excludePatterns as $excludePattern) {
                            if (strpos($line, $excludePattern) !== false) {
                                $shouldExclude = true;
                                break;
                            }
                        }
                        
                        if (!$shouldExclude) {
                            $results[] = [
                                'file' => str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $file->getPathname()),
                                'line' => $lineNumber + 1,
                                'pattern' => $pattern,
                                'description' => $description,
                                'content' => trim($line)
                            ];
                        }
                    }
                }
            }
        }
    }
    
    return $results;
}

$frontendDir = 'resources/views/frontend';

if (!is_dir($frontendDir)) {
    echo "❌ Directory $frontendDir not found!\n";
    exit(1);
}

$results = scanDirectory($frontendDir, $hardcodePatterns, $excludePatterns);

if (empty($results)) {
    echo "✅ No hardcode colors found! All files are using global color system.\n";
    exit(0);
}

echo "⚠️  Found " . count($results) . " hardcode color usage(s):\n\n";

$groupedResults = [];
foreach ($results as $result) {
    $groupedResults[$result['file']][] = $result;
}

foreach ($groupedResults as $file => $fileResults) {
    echo "📁 File: $file\n";
    echo str_repeat('-', 50) . "\n";
    
    foreach ($fileResults as $result) {
        echo sprintf(
            "   Line %d: %s (%s)\n   Code: %s\n\n",
            $result['line'],
            $result['pattern'],
            $result['description'],
            $result['content']
        );
    }
    echo "\n";
}

echo "💡 Recommendations:\n";
echo "==================\n";
echo "1. Replace hardcode colors with global classes from colors.css\n";
echo "2. Use semantic classes like .btn-primary, .text-heading, .apbdes-card\n";
echo "3. Check documentation/GLOBAL_COLOR_SYSTEM.md for available classes\n";
echo "4. Test changes thoroughly after replacement\n\n";

echo "🔧 Quick fixes:\n";
echo "===============\n";
echo "bg-blue-500     → .btn-primary or .apbdes-balance\n";
echo "bg-green-500    → .apbdes-pendapatan\n";
echo "bg-red-500      → .apbdes-belanja\n";
echo "text-gray-800   → .text-heading\n";
echo "text-gray-900   → .text-heading\n";
echo "bg-gray-800     → .section-bg-dark-fix\n";