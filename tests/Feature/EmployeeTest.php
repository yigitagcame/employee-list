<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use App\Employee;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_employee_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/api/employee',$this->user());

        $this->assertCount(1,Employee::all());

        $response->assertStatus(201);
    }

    /** @test */
    public function all_employees_can_be_getted()
    {
        $this->withoutExceptionHandling();

        $this->postJson('/api/employee',$this->user());

        $response = $this->getJson('/api/employee');

        $response->assertJson(Employee::all()->toArray(),false);

        $response->assertOk();
    }

    /** @test */
    public function an_employee_can_be_getted()
    {
        $this->withoutExceptionHandling();

        $post = $this->postJson('/api/employee',$this->user());

        $response = $this->getJson('/api/employee/'.json_decode($post->getContent())->id);

        $response->assertJson(json_decode($post->getContent(),true),false);

        $response->assertOk();
    }

    /** @test */
    public function an_employee_can_be_updated()
    {
        $this->withoutExceptionHandling();

        Employee::create(array_merge($this->user(),["photo" => '123123.jpg']));

        $newInfo = [
            "name" => "Non-Sally",
            "surname" => "Non-Brune"
        ];

        $response = $this->patchJson('/api/employee/'.Employee::first()->id,$newInfo);

        $this->assertCount(1,Employee::where("name","Non-Sally")->get());

        $response->assertOk();

    }

    /** @test */
    public function an_employee_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        Employee::create(array_merge($this->user(),["photo" => '123123.jpg']));

        $response = $this->deleteJson('/api/employee/'.Employee::first()->id);

        $this->assertCount(0,Employee::all());

        $response->assertOk();

    }


    private function user()
    {
        Storage::fake('photos');

        return [
            'name' => 'Sally',
            'surname' => 'Brune',
            'photo' => UploadedFile::fake()->image('photo.jpg'),
            'comment' => 'Such a nice employee, Isn\'t it honey?'
        ];
    }
}
