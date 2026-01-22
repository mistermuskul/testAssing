<?php

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private static $serverProcess;
    private static $serverPort = 8888;
    private static $serverUrl = 'http://localhost:8888';

    public static function setUpBeforeClass(): void
    {
        $docRoot = __DIR__ . '/../';
        $router = __DIR__ . '/../router.php';
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $command = sprintf(
                'start /B php -S localhost:%d -t %s %s',
                self::$serverPort,
                escapeshellarg($docRoot),
                escapeshellarg($router)
            );
            pclose(popen($command, 'r'));
        } else {
            $command = sprintf(
                'php -S localhost:%d -t %s %s > /dev/null 2>&1 & echo $!',
                self::$serverPort,
                escapeshellarg($docRoot),
                escapeshellarg($router)
            );
            exec($command, $output);
            self::$serverProcess = isset($output[0]) ? (int)$output[0] : null;
        }
        
        $maxAttempts = 10;
        $attempt = 0;
        while ($attempt < $maxAttempts) {
            $ch = curl_init(self::$serverUrl . '/users');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode > 0) {
                break;
            }
            usleep(500000);
            $attempt++;
        }
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$serverProcess && strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            exec('kill ' . self::$serverProcess);
        } else {
            exec('taskkill /F /IM php.exe /FI "WINDOWTITLE eq php*" 2>nul');
        }
    }

    public function testUserApiReturnsUsers()
    {
        $ch = curl_init(self::$serverUrl . '/users');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(200, $httpCode, 'API should return HTTP 200');
        
        $data = json_decode($response, true);
        $this->assertIsArray($data, 'Response should be valid JSON array');
        $this->assertNotEmpty($data, 'Response should not be empty');
        $this->assertArrayHasKey('id', $data[0], 'User should have id field');
        $this->assertArrayHasKey('name', $data[0], 'User should have name field');
        $this->assertArrayHasKey('email', $data[0], 'User should have email field');
    }
}
