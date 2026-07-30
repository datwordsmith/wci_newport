<?php

$dir = __DIR__ . '/app/Livewire/Public/';
$files = glob($dir . '*.php');

foreach ($files as $file) {
    // Skip SingleEvent and SingleNewsUpdate as they were manually fixed
    if (basename($file) === 'SingleEvent.php' || basename($file) === 'SingleNewsUpdate.php') {
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Check if the file has public $description
    if (strpos($content, '$description') !== false) {
        
        // Match return view(...); or return view(...)->layout(...);
        // We'll replace it by appending ->layoutData(['description' => $this->description])
        // Example: return view('livewire.public.service-units')->layout('layouts.main');
        // Example: return view('livewire.public.about');
        
        // Find the render method
        if (preg_match('/public function render\(\).*?\{.*?(return view\([^\)]+\).*?;)/s', $content, $matches)) {
            $returnStatement = $matches[1];
            
            // If it already has layoutData, skip
            if (strpos($returnStatement, 'layoutData') !== false) {
                continue;
            }
            
            // We want to insert ->layoutData(['description' => $this->description]) before the semicolon
            $newReturnStatement = rtrim($returnStatement, ';');
            $newReturnStatement .= "->layoutData(['description' => \$this->description]);";
            
            $content = str_replace($returnStatement, $newReturnStatement, $content);
            file_put_contents($file, $content);
            echo "Updated " . basename($file) . "\n";
        }
    }
}
echo "Done.\n";
