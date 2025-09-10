<?php

namespace App\Tests\Security;

use App\Security\Security;
use PHPUnit\Framework\TestCase;

class SecurityTest extends TestCase
{
    private Security $security;

    public function setUp(): void
    {
        $this->security = new Security();
    }

    public function testVerificationIfUserIsLogged(): void
    {
        $_SESSION['user'] = [];
        $userIsLogged = $this->security->isLogged();
        $this->assertTrue($userIsLogged);
    }

    public function testVerificationIfUserIsAPassager(): void
    {
        $_SESSION['user'] = ['role' => '1'];
        $isPassager = $this->security->isPassager();
        $this->assertTrue($isPassager);
    }

    public function testVerificationIfUserIsADriver(): void
    {
        $_SESSION['user'] = ['role' => '2'];
        $isChauffeur = $this->security->isChauffeur();
        $this->assertTrue($isChauffeur);
    }

    public function testVerificationIfUserIsAEmployee(): void
    {
        $_SESSION['user'] = ['role' => '4'];
        $isEmploye = $this->security->isEmploye();
        $this->assertTrue($isEmploye);
    }

    public function testVerificationIfUserIsAnAdmin(): void
    {
        $_SESSION['user'] = ['role' => '5'];
        $isAdmin = $this->security->isAdmin();
        $this->assertTrue($isAdmin);
    }

    public function testAppIsInProduction(): void
    {
        $_SERVER['HTTP_HOST'] = "ecoride.juangil.fr";
        $appInProd = $this->security->inProduction();
        $this->assertTrue($appInProd);
    }

    public function testAppIsInLocal(): void
    {
        $_SERVER['HTTP_HOST'] = "localhost";
        $appInLocal = $this->security->inProduction();
        $this->assertFalse($appInLocal);
    }

    public function testEncryptAndDecryptUrlParameterWorksCorrectly(): void
    {
        // 1: Créer un fichier temporaire avec une clé pour le test
        $testKey = "1234567890abcdef"; // 16 bytes pour AES-128
        $configContent = "<?php return ['ENCRYPTER_KEY' => '$testKey'];";
        // Directoire temporaire
        $tempDir = sys_get_temp_dir();
        $tempConfigPath = $tempDir . '/config.php';
        // Créer le fichier temporaire avec son contenu
        file_put_contents($tempConfigPath, $configContent);

        // 2: Definir la constante BASE_PATH dans le fichier temporaire
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', $tempDir);
        }

        // 3: Encrypter et decrypter une valeur
        $originalValue = "TestId123";
        $encrypted = $this->security->encryptUrlParameter($originalValue);
        $decrypted = $this->security->decryptUrlParameter($encrypted);

        // 4: Assert
        $this->assertEquals($originalValue, $decrypted);

        // 5: Supprimer le fichier temporaire
        unlink($tempConfigPath);
    }
}
