<?php

namespace Tests\Feature;

use App\KKM;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KKMViewTest extends TestCase
{
    use DatabaseMigrations;

    private $_user;

    public function setUp(): void
    {
        parent::setUp();

        $this->_user = factory(User::class)->create();
    }

    /**
     * Аутентифицированный пользователь может открыть страницу с ККМ.
     * @test
     * @return void
     */
    public function auth_user_can_open_kkm_page()
    {
        $this->actingAs($this->_user)
            ->get('/kkm')
            ->assertStatus(200);
    }

    /**
     * Неаутентифицированный пользователь будет перемещён на страницу аутентификации.
     * @test
     * @return void
     */
    public function an_unauthenticated_user_will_be_redirected_to_the_authentication_page()
    {
        $this->get('/kkm')
            ->assertRedirect('/login');
    }

    /**
     * Аутентифицированный пользователь может увидеть нужный шаблон страницы с ККМ.
     * @test
     * @return void
     */
    public function auth_user_can_see_current_view()
    {
        $this->actingAs($this->_user)
            ->get('/kkm')
            ->assertViewIs('kkm.index');
    }


    /**
     * Аутентифицированный пользователь может получить коллекцию с правильными данными.
     * @test
     * @return void
     */
    public function authenticated_user_can_get_a_collection_with_correct_data()
    {
        $kkms = factory(KKM::class, 5)->create();
        $this->actingAs($this->_user)
            ->json('get', route('kkm.index'))
            ->assertStatus(200)
            ->assertJsonPath('data', $kkms->toArray());
    }


}
