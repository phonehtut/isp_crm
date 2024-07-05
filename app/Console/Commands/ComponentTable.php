<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;

class ComponentTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:componentTable {tableName? : The name of the table} {--suffix=TableComponents}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tableName = $this->argument('tableName');
        $suffix = $this->option('suffix');

        // Prompt for tableName if not provided
        if (!$tableName) {
            $tableName = text(
                label: 'Enter Component Table Name',
                required: true,
            );
        }

        // Validate that the table name starts with an uppercase letter
        if (!ctype_upper(substr($tableName, 0, 1))) {
            $this->error('Table name must start with an uppercase letter.');
            return;
        }

        // Ask for confirmation
        if (!confirm(
            label: "Create table component with name '{$tableName}{$suffix}'?",
            default: false
        )) {
            $this->info('Command cancelled.');
            return;
        }

        // Initialize progress bar with 3 steps
        $this->output->progressStart(3);

        // Step 1: Create table component file
        $this->output->progressAdvance();
        $className = $tableName . $suffix;
        $filePath = app_path("Services/Components/Tables/{$className}.php");
        $namespace = 'App\Services\Components\Tables';

        $this->makeComponentTable($filePath, $namespace, $className);

        // Step 2: Display success message with file path
        $this->output->progressAdvance();
        $this->info("{$className} created successfully.");
        $this->info("Path: {$filePath}");

        // Step 3: Finish progress bar
        $this->output->progressFinish();
    }

    protected function makeComponentTable($filePath, $namespace, $className)
    {
        $stub = $this->getStub('ComponentCreate.stub');
        $stub = str_replace('{{namespace}}', $namespace, $stub);
        $stub = str_replace('{{className}}', $className, $stub);

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        file_put_contents($filePath, $stub);
    }

    protected function getStub($stub)
    {
        return file_get_contents(resource_path("stubs/{$stub}"));
    }
}
