<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LanguageRequest;
use App\Http\Requests\TranslationUpdateRequest;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Language;
use Artisan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class LanguageController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(
            'demo',
            ['only' => ['destroy']]
        );
    }

    /**
     * Available localization list
     *
     * @return     JsonResponse  The json response.
     */
    public function index(): JsonResponse
    {
        return response()->json(LanguageResource::collection(Language::get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\LanguageRequest  $request  The request
     *
     * @return     JsonResponse                        The json response.
     */
    public function store(LanguageRequest $request): JsonResponse
    {
        $language = Language::create($request->validated());
        if (config('laravel-translatable-string-exporter.synchronizer_state')) {
            Artisan::call('translatable:export', ['lang' => $language->locale]);
        } else {
            $enFile = base_path('/resources/lang/en.json');
            $newfile = base_path('/resources/lang/' . $language->locale . '.json');
            \File::copy($enFile, $newfile);
        }
        return response()->json(
            [
                'message' => __('Data saved successfully'),
                'language' => new LanguageResource($language),
            ]
        );
    }

    /**
     * Display specific resource
     *
     * @param      \App\Models\Language  $language  The language
     *
     * @return     JsonResponse          The json response.
     */
    public function show(Language $language): JsonResponse
    {
        if (!file_exists(base_path() . '/resources/lang/' . $language->locale . '.json')) {
            return response()->json(
                ['message' => __('No translations found for the selected language')],
                500
            );
        }
        $translations = [];
        $files = json_decode(
            File::get(base_path() . '/resources/lang/' . $language->locale . '.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        foreach ($files as $key => $value) {
            $translations[] = ['key' => $key, 'value' => $value];
        }
        return response()->json(
            [
                'language' => new LanguageResource($language),
                'translations' => $translations,
            ]
        );
    }

    /**
     * Update specific resource
     *
     * @param      \App\Http\Requests\TranslationUpdateRequest  $request   The request
     * @param      \App\Models\Language                         $language  The language
     *
     * @return     JsonResponse                                 The json response.
     */
    public function update(TranslationUpdateRequest $request, Language $language): JsonResponse
    {
        if ($language->isPrime()) {
            return response()->json(
                ['message' => __('Can\'t update english language,please create new language for localization')],
                406
            );
        }
        $request->validated();
        $translations = json_decode(
            File::get(base_path() . '/resources/lang/' . $language->locale . '.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        foreach ($request->get('strings') as $string) {
            $translations[$string['key']] = $string['value'];
        }
        if (File::put(
            base_path() . '/resources/lang/' . $language->locale . '.json',
            json_encode($translations, JSON_THROW_ON_ERROR)
        )) {
            return response()->json(
                [
                    'message' => __('Data updated successfully'),
                    'language' => new LanguageResource($language),
                ]
            );
        }
        return response()->json(
            ['message' => __('Something went wrong try again !')],
            500
        );
    }

    /**
     * Destroys the given language.
     *
     * @param      \App\Models\Language  $language  The language
     *
     * @return     JsonResponse          The json response.
     */
    public function destroy(Language $language): JsonResponse
    {
        if ($language->isPrime() || $language->isDefault()) {
            return response()->json(
                ['message' => __('Can\'t delete default language')],
                406
            );
        }
        $locale = $language->locale . '.json';
        if (File::exists(base_path('/resources/lang/' . $locale))) {
            File::delete(base_path('/resources/lang/' . $locale));
        }
        $language->delete();
        return response()->json(
            ['message' => __('Data removed successfully')]
        );
        return response()->json(
            ['message' => __('An error occurred while deleting data')],
            500
        );
    }

    /**
     * Synchronizes the object.
     *
     * @return     JsonResponse  The json response.
     */
    public function sync(): JsonResponse
    {
        try {
            $languages = Language::get();
            if (config('laravel-translatable-string-exporter.synchronizer_state')) {
                foreach ($languages as $language) {
                    @Artisan::call('translatable:export', ['lang' => $language->locale]);
                }
            }
            return response()->json(
                [
                    'message' => __('Translation files updated correctly'),
                    'output' => @Artisan::output(),
                ]
            );
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
