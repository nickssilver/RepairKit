<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use dacoto\EnvSet\Facades\EnvSet;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * System configuration
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return   mixed
     */
    public function protection(Request $request)
    {
        EnvSet::setKey(strtoupper('app_pack'), $request->package_hash ?? null);
        EnvSet::setKey(strtoupper('app_debug'), $request->app_debug ?? false);
        EnvSet::save();
        return redirect('/?version=' . config('app.version') . '&message=Application_configuration_saved_successfully');
    }

    /**
     * Provides default settings for all controllers
     * extended by controller
     *
     * @return object
     */
    protected function master(): object
    {
        return Setting::find(1);
    }

    /**
     * DataTable sorting for common resources
     *
     * @param mixed $request
     *
     * @return array
     */
    protected function sort($request): array
    {
        return $request->get('sort', json_decode(json_encode(['order' => 'asc', 'column' => 'created_at']),
            true,
            512,
            JSON_THROW_ON_ERROR
        ));

    }

    /**
     * Generate pagination for common dataTables
     * @param \Illuminate\Database\Eloquent\Collection $items
     *
     * @return array
     */
    protected function pagination($items): array
    {
        return [
            'currentPage' => $items->currentPage(),
            'perPage' => $items->perPage(),
            'total' => $items->total(),
            'totalPages' => $items->lastPage(),
        ];
    }

    protected function getAdmin()
    {
        $admin = User::where('id', 1)->first();
        return $admin ?? null;
    }

}
