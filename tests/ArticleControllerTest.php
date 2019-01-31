<?php

namespace App\tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testGetArticles()
    {
        $client = static::createClient();
        $client->request( 'GET', '/api/articles', [], [], ['HTTP_ACCEPT' => 'application/json'] );
        // http_accept : header
        $response = $client->getResponse();
        $content = $response->getContent();
        $this->assertEquals( 200, $response->getStatusCode() );
        // verifie la reponse
        $this->assertJson( $content );
        // verifie que le contenu est bien du json
        $arrayContent = \json_decode( $content, true );
        $this->assertCount( 10, $arrayContent );
    }

    public function testPostArticles()
    {
        $client = static::createClient();
        $client->request( 'POST', '/api/articles', [], [],
            [
                'HTTP_ACCEPT' => 'application/json',
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-AUTH-TOKEN' => 'admin'
            ],
            // => headers
            '{"name": "test","description": "testtesttesttesttesttesttest","createdAt":"2017-05-12 00:00:00", "user":{"id": 222}}'
        );
        $response = $client->getResponse();
        $content = $response->getContent();
        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertJson( $content );
    }
}