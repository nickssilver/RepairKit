<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

/**
 * Generate/restore backups
 */
class BackupController extends ApiController
{
    protected $backups = [];

    /**
     * Construct middleware and initiated backups list
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin']);
        $this->middleware('demo')->only(['restore', 'destroy']);
        $this->backups = glob(storage_path() . '/backups/*.sql');
    }

    /**
     * Backup list
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $files = [];
        foreach ($this->backups as $file) {
            if (!\File::exists($file)) {
                continue;
            }
            $info = [];
            $info['uuid'] = Str::orderedUuid();
            $info['name'] = \Illuminate\Support\Arr::last(explode('/', $file));
            $info['size'] = number_format(\File::size($file) / 1048576, 2) . 'MB';
            $info['time'] = date('Dd-M-Y H:i:s', filemtime($file));
            $files[] = $info;
        }
        rsort($files);
        return response()->json(['list' => $files], 200);
    }

    /**
     * Generate backup
     *
     * @return JsonResponse
     */
    public function generate(): JsonResponse
    {
        if (count($this->backups) > config('database.backups_limit')) {
            return response()->json(
                ['message' => __('You can\'t generate more then preset backups')],
                500
            );
        }
        $process = Process::fromShellCommandline(
            'mysqldump -u'
            . config('database.connections.mysql.username') . ' -p'
            . config('database.connections.mysql.password') . ' '
            . config('database.connections.mysql.database') . ' > '
            . storage_path('backups/backup-' . date('d-m-Y-H-i-s') . '.sql')
        );
        if ($process->mustRun() !== false) {
            return response()->json(
                ['message' => __('Backup created successfully')],
                200
            );
        }
        return response()->json(
            ['message' => __('Something went wrong try again !')],
            500
        );
    }

    /**
     * Restore backup
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function restore(Request $request): JsonResponse
    {

        try {
            DB::beginTransaction();
            DB::unprepared(
                file_get_contents(storage_path() . '/backups/' . $request->file)
            );
            return response()->json(
                ['message' => __('Database restored successfully')],
                200
            );
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json(
                [
                    'message' => __('Something went wrong try again !'),
                    'errors' => $error->getMessage(),
                ],
                500
            );
        }
    }

    /**
     * Destroy backup
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $filePath = storage_path() . '/backups/' . $request->file;
        if (file_exists($filePath)) {
            File::delete($filePath);
            return response()->json(
                ['message' => __('Backup removed successfully')],
                200
            );
        }
        return response()->json(['message' => __('File does not exist !')], 200);
    }
}
