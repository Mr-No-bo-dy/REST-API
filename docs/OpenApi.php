<?php

namespace Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Test Laravel REST API",
 *     version="0.6.0",
 *     description="Це тестовий проєкт REST API на Laravel. Документація реалізована за допомогою пакета darkaonline/l5-swagger.",
 * ),
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Локальний сервер",
 * ),
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="",
 * ),
 */
class OpenApi {}
