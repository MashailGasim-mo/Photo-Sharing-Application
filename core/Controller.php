<?php

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        $viewPath = DIR . '/../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
            return;
        }

        http_response_code(404);
        echo 'View not found.';
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data);
        exit;
    }
}