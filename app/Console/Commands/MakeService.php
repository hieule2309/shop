<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * Tên và chữ ký của lệnh console.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * Mô tả của lệnh console.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Thực thi lệnh console.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        // Kiểm tra nếu Service đã tồn tại
        if (File::exists($path)) {
            $this->error("Service {$name} already exists!");
            return Command::FAILURE;
        }

        // Nội dung của file Service
        $content = <<<PHP
        <?php

        namespace App\Services;

        class {$name}
        {
            // Add your service methods here
        }
        PHP;

        // Tạo thư mục nếu chưa tồn tại
        File::ensureDirectoryExists(app_path('Services'));

        // Tạo file Service
        File::put($path, $content);

        $this->info("Service {$name} created successfully.");
        return Command::SUCCESS;
    }
}
