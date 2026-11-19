<?php

declare(strict_types=1);

$root = dirname(__DIR__);

require_once $root . '/vendor/autoload.php';

use Symfony\Component\Process\Process;

// Spaces everywhere (#114): fails when any tracked text file contains a tab.
// The .editorconfig default states the preference; this sweep is the
// enforcement, because PHPStan and PHPCS cannot tokenize NEON, XML, or YAML.
// Tool-generated trees outside our control (graphify-out) are excluded.
$process = new Process(['git', '-C', $root, 'ls-files']);
$process->run();

$exitCode = $process->getExitCode() ?? 1;

$files = ($process->isSuccessful())
    ? explode("\n", trim($process->getOutput()))
    : [];
if ($exitCode !== 0) {
    fwrite(STDERR, 'Unable to list tracked files.' . PHP_EOL);
    exit(1);
}

$offenders = [];
foreach ($files as $file) {
    if (str_starts_with($file, 'graphify-out/')) {
        continue;
    }

    $contents = file_get_contents($root . '/' . $file);
    if ($contents === false || str_contains($contents, "\0")) {
        continue;
    }

    if (str_contains($contents, "\t")) {
        $offenders[] = $file;
    }
}

if ($offenders !== []) {
    fwrite(STDERR, 'Tabs found in tracked files:' . PHP_EOL);
    foreach ($offenders as $offender) {
        fwrite(STDERR, '  ' . $offender . PHP_EOL);
    }

    exit(1);
}
