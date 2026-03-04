<?php 

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    protected int $statusCode;
    protected array $errors;

    public function __construct(
        string $message = "Something went wrong",
        int $statusCode = 400,
        array $errors = []
    ) {
        parent::__construct($message);

        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    /**
     * Render JSON response
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors'  => $this->errors,
        ], $this->statusCode);
    }

    /**
     * 404 Not Found
     */
    public static function notFound(string $message = "Resource not found"): self
    {
        return new self($message, 404);
    }

    /**
     * 401 Unauthorized
     */
    public static function unauthorized(string $message = "Unauthorized"): self
    {
        return new self($message, 401);
    }

    /**
     * 422 Validation Error
     */
    public static function validation(string $message = "Validation failed", array $errors = []): self
    {
        return new self($message, 422, $errors);
    }

    /**
     * 500 Server Error
     */
    public static function serverError(string $message = "Internal server error"): self
    {
        return new self($message, 500);
    }
}