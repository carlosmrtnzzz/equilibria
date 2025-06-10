<?php

use App\Http\Controllers\PlanController;
use PHPUnit\Framework\TestCase;

class PlanControllerTest extends TestCase
{
    public function testGetCalorieAdjustmentLoseWeightMale()
    {
        $user = (object) [
            'gender' => 'male',
            'weight_kg' => 80,
            'height_cm' => 180,
            'age' => 30,
            'goal' => 'lose_weight'
        ];
        $controller = new PlanController();
        $result = $this->invokeMethod($controller, 'getCalorieAdjustment', [$user]);
        $bmr = 88.362 + (13.397 * 80) + (4.799 * 180) - (5.677 * 30);
        $expected = $bmr * 0.85;
        $this->assertEqualsWithDelta($expected, $result, 0.01);
    }

    public function testGetCalorieAdjustmentGainWeightFemale()
    {
        $user = (object) [
            'gender' => 'female',
            'weight_kg' => 60,
            'height_cm' => 165,
            'age' => 25,
            'goal' => 'gain_weight'
        ];
        $controller = new PlanController();
        $result = $this->invokeMethod($controller, 'getCalorieAdjustment', [$user]);
        $bmr = 447.593 + (9.247 * 60) + (3.098 * 165) - (4.330 * 25);
        $expected = $bmr * 1.15;
        $this->assertEqualsWithDelta($expected, $result, 0.01);
    }

    public function testGetCalorieAdjustmentMaintain()
    {
        $user = (object) [
            'gender' => 'male',
            'weight_kg' => 70,
            'height_cm' => 175,
            'age' => 40,
            'goal' => 'maintain'
        ];
        $controller = new PlanController();
        $result = $this->invokeMethod($controller, 'getCalorieAdjustment', [$user]);
        $bmr = 88.362 + (13.397 * 70) + (4.799 * 175) - (5.677 * 40);
        $expected = $bmr;
        $this->assertEqualsWithDelta($expected, $result, 0.01);
    }

    public function testGetIntoleranciasPromptTextIncluyeCorrecto()
    {
        $controller = new PlanController();
        $preferences = (object) [
            'is_celiac' => 1,
            'is_lactose_intolerant' => 0,
            'is_fructose_intolerant' => 1,
            'is_histamine_intolerant' => 0,
            'is_sorbitol_intolerant' => 0,
            'is_casein_intolerant' => 0,
            'is_egg_intolerant' => 0,
        ];
        $texto = $this->invokeMethod($controller, 'getIntoleranciasPromptText', [$preferences]);
        $this->assertStringContainsString('gluten', $texto);
        $this->assertStringContainsString('fructosa', $texto);
        $this->assertStringContainsString('OBLIGATORIAS', $texto);
    }

    public function testGetIntoleranciasPromptTextSinIntolerancias()
    {
        $controller = new PlanController();
        $preferences = (object) [
            'is_celiac' => 0,
            'is_lactose_intolerant' => 0,
            'is_fructose_intolerant' => 0,
            'is_histamine_intolerant' => 0,
            'is_sorbitol_intolerant' => 0,
            'is_casein_intolerant' => 0,
            'is_egg_intolerant' => 0,
        ];
        $texto = $this->invokeMethod($controller, 'getIntoleranciasPromptText', [$preferences]);
        $this->assertEmpty($texto);
    }

    public function testGetIntoleranciasPromptTextVariasIntolerancias()
    {
        $controller = new PlanController();
        $preferences = (object) [
            'is_celiac' => 1,
            'is_lactose_intolerant' => 1,
            'is_fructose_intolerant' => 1,
            'is_histamine_intolerant' => 1,
            'is_sorbitol_intolerant' => 0,
            'is_casein_intolerant' => 0,
            'is_egg_intolerant' => 0,
        ];
        $texto = $this->invokeMethod($controller, 'getIntoleranciasPromptText', [$preferences]);
        $this->assertStringContainsString('gluten', $texto);
        $this->assertStringContainsString('lactosa', $texto);
        $this->assertStringContainsString('fructosa', $texto);
        $this->assertStringContainsString('histamina', $texto);
    }

    public function testBuildPromptIncluyePlatosYRestricciones()
    {
        $controller = new PlanController();
        $platos = [
            ['dia' => 'lunes', 'tipo' => 'comida'],
            ['dia' => 'martes', 'tipo' => 'cena'],
        ];
        $originalPlan = [
            'lunes' => ['comida' => 'Pollo con arroz'],
            'martes' => ['cena' => 'Pescado al horno'],
        ];
        $textoIntolerancias = "Sin gluten. ";
        $prompt = $this->invokeMethod($controller, 'buildPrompt', [$platos, $originalPlan, $textoIntolerancias]);
        $this->assertStringContainsString('Sin gluten.', $prompt);
        $this->assertStringContainsString('lunes', $prompt);
        $this->assertStringContainsString('Pollo con arroz', $prompt);
        $this->assertStringContainsString('martes', $prompt);
        $this->assertStringContainsString('Pescado al horno', $prompt);
        $this->assertStringContainsString('"lunes": {', $prompt);
        $this->assertStringContainsString('"comida": "..."', $prompt);
    }

    public function testBuildPromptSinIntolerancias()
    {
        $controller = new PlanController();
        $platos = [
            ['dia' => 'miércoles', 'tipo' => 'desayuno'],
        ];
        $originalPlan = [
            'miércoles' => ['desayuno' => 'Tostadas integrales'],
        ];
        $textoIntolerancias = "";
        $prompt = $this->invokeMethod($controller, 'buildPrompt', [$platos, $originalPlan, $textoIntolerancias]);
        $this->assertStringContainsString('miércoles', $prompt);
        $this->assertStringContainsString('Tostadas integrales', $prompt);
        $this->assertStringContainsString('"desayuno": "..."', $prompt);
    }

    public function testActualizaPlatosSoloModificaSeleccionados()
    {
        $controller = new PlanController();
        $originalPlan = [
            'lunes' => ['comida' => 'Pollo', 'cena' => 'Pescado'],
            'martes' => ['comida' => 'Ensalada', 'cena' => 'Tortilla'],
        ];
        $nuevoJson = [
            'lunes' => ['comida' => 'Ternera'],
            'martes' => ['cena' => 'Merluza'],
        ];
        $platosAReemplazar = [
            ['dia' => 'lunes', 'tipo' => 'comida'],
            ['dia' => 'martes', 'tipo' => 'cena'],
        ];
        $this->invokeMethod($controller, 'actualizaPlatos', [&$originalPlan, $nuevoJson, $platosAReemplazar]);
        $this->assertEquals('Ternera', $originalPlan['lunes']['comida']);
        $this->assertEquals('Merluza', $originalPlan['martes']['cena']);
        $this->assertEquals('Pescado', $originalPlan['lunes']['cena']);
        $this->assertEquals('Ensalada', $originalPlan['martes']['comida']);
    }

    public function testActualizaPlatosNoModificaSiNoExisteEnNuevoJson()
    {
        $controller = new PlanController();
        $originalPlan = [
            'jueves' => ['comida' => 'Arroz', 'cena' => 'Pollo'],
        ];
        $nuevoJson = [
            // No hay 'cena' en el nuevoJson
            'jueves' => ['comida' => 'Pasta'],
        ];
        $platosAReemplazar = [
            ['dia' => 'jueves', 'tipo' => 'comida'],
            ['dia' => 'jueves', 'tipo' => 'cena'],
        ];
        $this->invokeMethod($controller, 'actualizaPlatos', [&$originalPlan, $nuevoJson, $platosAReemplazar]);
        $this->assertEquals('Pasta', $originalPlan['jueves']['comida']);
        $this->assertEquals('Pollo', $originalPlan['jueves']['cena']); // No debe cambiar
    }

    public function testBuildPromptConPlatosVacios()
    {
        $controller = new PlanController();
        $platos = [];
        $originalPlan = [];
        $textoIntolerancias = "";
        $prompt = $this->invokeMethod($controller, 'buildPrompt', [$platos, $originalPlan, $textoIntolerancias]);
        $this->assertIsString($prompt);
        $this->assertNotEmpty($prompt); // El prompt debe tener instrucciones aunque no haya platos
    }

    public function testGetIntoleranciasPromptTextPreferenciasNull()
    {
        $controller = new PlanController();
        $texto = $this->invokeMethod($controller, 'getIntoleranciasPromptText', [null]);
        $this->assertEmpty($texto);
    }

    public function testActualizaPlatosSinPlatosAReemplazar()
    {
        $controller = new PlanController();
        $originalPlan = [
            'lunes' => ['comida' => 'Pollo', 'cena' => 'Pescado'],
        ];
        $nuevoJson = [
            'lunes' => ['comida' => 'Ternera'],
        ];
        $platosAReemplazar = [];
        $this->invokeMethod($controller, 'actualizaPlatos', [&$originalPlan, $nuevoJson, $platosAReemplazar]);
        $this->assertEquals('Pollo', $originalPlan['lunes']['comida']);
    }

    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}