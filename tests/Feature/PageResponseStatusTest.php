<?php

test('testando codigo 200')->get('/')->assertStatus(200)->assertOk();

test('testando codigo 404')->get('/404')->assertStatus(404)->assertNotFound();

test('testando codigo 403:: não tem permissão de acesso')->get('/403')->assertStatus(403)->assertForbidden();


