<?php

namespace Tests\Feature;

use Database\Factories\TodoFactory;
use Database\Factories\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TodoTest extends TestCase
{

    public function testTodoIndexResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $response = $this->getJson(route("todo.index"));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoIndexResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {
        $user = UserFactory::new()->create();
        $response = $this->actingAs($user)->getJson(route("todo.index"));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTodoIndexResponsesHttpNotFoundWhenUserHasNoTodos(): void
    {
        $user = UserFactory::new()->create(['email_verified_at' => now()->carbonize()]);
        $this->actingAs($user)->getJson(route("todo.index"))->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testTodoIndexResponsesHttpOk(): void
    {
        $user = UserFactory::new()->create(['email_verified_at' => now()->carbonize()]);
        TodoFactory::new()->for($user)->createMany(10);
        $this->actingAs($user)->getJson(route('todo.index'))->assertStatus(Response::HTTP_OK);
    }

    public function testTodoIndexResponsesOnlyCurrentUsersTodos(): void
    {
        $user1 = UserFactory::new()->create();
        $user2 = UserFactory::new()->create();

        TodoFactory::new()->for($user1)->createMany(10);
        TodoFactory::new()->for($user2)->createMany(10);
        $response = $this->actingAs($user1)->getJson(route('todo.index'));
        $response->assertStatus(Response::HTTP_OK);

        $response = $response->getContent();
        foreach ($response['data'] as $todo) {
            $this->assertSame($user1->id, $todo['user_id']);
        }
    }

    public function testTodoStoreResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $response = $this->postJson(route("todo.store"));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testTodoStoreResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {

    }

    public function testTodoStoreResponsesHttpUnprocessableEntityWhenDescriptionIsNotInBody(): void
    {

    }

    public function testTodoStoreResponsesHttpCreated(): void
    {

    }

    public function testTodoStoreCreatesTodo(): void
    {

    }

    public function testTodoShowResponsesHttpNotFoundWhenTodoDoesNotExist(): void
    {

    }

    public function testTodoShowResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {

    }

    public function testTodoShowResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {

    }

    public function testTodoShowResponsesHttpUnauthorizedWhenUserTryingToUpdateOtherUsersTodo(): void
    {

    }

    public function testTodoShowResponsesHttpOk(): void
    {

    }

    public function testTodoUpdateResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {

    }

    public function testTodoUpdateResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {

    }

    public function testTodoUpdateResponsesHttpNotFoundWhenTodoDoesNotExist(): void
    {

    }

    public function testTodoUpdateResponsesHttpUnauthorizedWhenUserIsTryingToUpdateOtherUsersTodo(): void
    {

    }

    public function testTodoUpdateResponsesHttpAccepted(): void
    {

    }

    public function testTodoUpdateUpdatesTodo(): void
    {

    }

    public function testTodoDeleteResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {

    }

    public function testTodoDeleteResponsesHttpForbiddenWhenUsersEmailIsNotVerified(): void
    {

    }

    public function testTodoDeleteResponsesHttpNotFoundWhenTodoDoesNotExist(): void
    {

    }

    public function testTodoDeleteResponsesHttpUnauthorizedWhenUserIsTryingToDeleteOtherUsersTodo(): void
    {

    }

    public function testTodoDeleteResponsesHttpAccepted(): void
    {

    }

    public function testTodoDeleteDeletesTodo(): void
    {

    }
}
