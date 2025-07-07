<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

abstract class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    
    /**
     * Return success response with data
     *
     * @param array $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function respondSuccess(array $data = [], string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }
    
    /**
     * Return error response
     *
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     * @return JsonResponse
     */
    protected function respondError(string $message = 'Error', int $statusCode = 400, array $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];
        
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        
        return response()->json($response, $statusCode);
    }
    
    /**
     * Render index page with data for Inertia
     *
     * @param string $component
     * @param array $props
     * @return InertiaResponse
     */
    protected function renderIndex(string $component, array $props = []): InertiaResponse
    {
        return Inertia::render($component, $props);
    }
    
    /**
     * Flash a message to the session
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    protected function flash(string $type, string $message): void
    {
        session()->flash('flash', [
            'type' => $type,
            'message' => $message,
        ]);
    }
    
    /**
     * Flash a success message
     *
     * @param string $message
     * @return void
     */
    protected function flashSuccess(string $message): void
    {
        $this->flash('success', $message);
    }
    
    /**
     * Flash an error message
     *
     * @param string $message
     * @return void
     */
    protected function flashError(string $message): void
    {
        $this->flash('error', $message);
    }
    
    /**
     * Flash a warning message
     *
     * @param string $message
     * @return void
     */
    protected function flashWarning(string $message): void
    {
        $this->flash('warning', $message);
    }
    
    /**
     * Flash an info message
     *
     * @param string $message
     * @return void
     */
    protected function flashInfo(string $message): void
    {
        $this->flash('info', $message);
    }
}
