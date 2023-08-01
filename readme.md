# Pacote Laravel Address

O pacote Laravel Address fornece um conjunto de ferramentas para lidar e gerenciar informações relacionadas a endereços, incluindo países, regiões, estados, cidades, bairros, ruas e endereços. Este pacote permite que você armazene, recupere e manipule facilmente informações de endereço dentro da sua aplicação Laravel.

## Instalação

Para instalar o pacote Laravel Address, você pode usar o Composer:

```bash
composer require confrariaweb/laravel-address
``` 

O pacote será automaticamente descoberto e registrado pelo Laravel.

## Uso

Depois de instalar o pacote, você pode usar as classes e métodos fornecidos para trabalhar com dados relacionados a endereços em sua aplicação.

### Criar um Novo Endereço

Para criar um novo endereço, você pode usar a classe `AddressService`. Primeiro, você precisa definir os dados para o endereço usando o método `setData`. Os dados devem ser um array contendo as informações do endereço, incluindo país, estado, cidade, bairro, rua e outros detalhes relevantes.

```php

use ConfrariaWeb\Address\Services\AddressService;

// Defina os dados do endereço
$data = [
    'country' => 'Brasil',
    'state' => 'São Paulo',
    'city' => 'São Paulo',
    'neighborhood' => 'Moema',
    'street' => 'Avenida Ibirapuera',
    'number' => '123',
    'complement' => 'Apto 4',
];

// Crie um novo endereço
$addressService = new AddressService();
$endereco = $addressService->setData($data)->firstOrCreateInCascade();` 
```

O método `firstOrCreateInCascade` criará o endereço e todos os dados relacionados em cascata, começando pelo país e seguindo até o endereço.

### Recuperar Endereços

Para recuperar endereços, você pode usar as classes de modelo respectivas, como `Country`, `State`, `City`, etc.

```php

use ConfrariaWeb\Address\Models\City;

// Recupere todas as cidades
$cidades = City::all();

// Recupere uma cidade específica por ID
$idCidade = 1;
$cidade = City::find($idCidade);

// Recupere cidades de um estado específico
$idEstado = 2;
$cidadesDoEstado = City::where('state_id', $idEstado)->get();` 
```

Você pode usar métodos semelhantes para outros modelos como `Country`, `State`, `Neighborhood`, etc.

### Atualizar um Endereço

Para atualizar um endereço, você pode usar a classe `AddressService` da mesma forma que criou um endereço. Primeiro, defina os dados para o endereço atualizado, incluindo o ID do endereço que você deseja atualizar.

```php

use ConfrariaWeb\Address\Services\AddressService;

// Defina os dados do endereço atualizado
$data = [
    'address_id' => 1, // O ID do endereço que você deseja atualizar
    'country' => 'Brasil',
    'state' => 'Rio de Janeiro',
    'city' => 'Rio de Janeiro',
    'neighborhood' => 'Copacabana',
    'street' => 'Avenida Atlântica',
    'number' => '456',
    'complement' => 'Apto 10',
];

// Atualize o endereço
$addressService = new AddressService();
$endereco = $addressService->setData($data)->firstOrCreateInCascade();` 
```

O método `firstOrCreateInCascade` atualizará o endereço e todos os dados relacionados em cascata, começando pelo país e seguindo até o endereço.

### Excluir um Endereço

Para excluir um endereço, você pode usar o método `delete` da classe do modelo respectivo.

```php

use ConfrariaWeb\Address\Models\Address;

// Exclua um endereço por ID
$idEndereco = 1;
Address::destroy($idEndereco);` 
```

## Contribuindo

Se encontrar algum problema ou tiver sugestões de melhorias, sinta-se à vontade para abrir uma issue ou enviar um pull request no GitHub: [Laravel Address GitHub](https://github.com/rafazingano/laravel-address)

## Licença

O pacote Laravel Address é um software de código aberto licenciado sob a licença MIT. 