_Isto não tem relaçao com os padrões de Modelos de Objetos, como, Java Object Model ou Document Object Model, trata-se de uma nomenclatura do framework Orion._

# Introduction #

Quando se utiliza a técnica de desenvolvimento ORM (Mapeamento Objeto-Relacional), cada tabela do banco de dados é representada por uma classe (Model) e os campos da tabela são objetos. Assim, o banco de dados, juntamente com todo o projeto, possuem o [paradigma](paradigma.md) orientado à objetos.
Os objetos do banco de dados, portanto, possuem todas as caracteristicas dos objetos nativos da linguagem.

ObjectModels para o Orion Framework são objetos abstratos, que podem ser herdados por muitos outros objetos mais específicos e reduzindo muito a programação e manutenção dos Models.

# Details #

Imagine que precisamos criar um simples banco de dados para uma escola. Esse banco de dados será formado, entre outras, pelas tabelas "Student" e "Teacher".

Veja a estrutura das tabelas Student e Teacher:
_O Orion utiliza o Doctrine ORM, esse ORM utiliza arquivos YAML para geração do schema do banco de dados_
```
# Models/Student.php
Student:
  columns:
    name:
      type: string(255)
      notnull: true
   nr_register:
      type: string(14)
      notnull: true
   course_id:
      type: integer
      notnull: true
    birth:
      type: date
      notnull: true
    address:
      type: string(255)
      notnull: true
    district:
      type: string(255)
    nr: 
      type: integer
    city_id:
      type: integer
    state_id:
      type: integer
    country_id:
      type: integer

# Models/Teacher.php
Teacher:
  columns:  
    name:
      type: string(255)
      notnull: true
    birth:
      type: date
      notnull: true
    language_id:
      type: integer
    address:
      type: string(255)
      notnull: true
    district:
      type: string(255)
      notnull: true
    nr:
      type: integer
    city_id:
      type: integer
    state_id:
      type: integer
    country_id:
      type: integer

```

Como estamos falando de objetos, podemos ver que o objeto "Student" e o objeto "Teacher" possuem muitas semelhanças e é nessas semelhanças que se baseia esse recurso do Orion.
Objetos são estruturas hierárquicas, que respeitam propriedades como Herança, Encapsulamento, etc.
Esta hierárquia pode ser vista nas tabelas acima, onde as propriedades (campos) "name, birth, address, district, nr, city\_id, state\_id, country\_id" são comuns aos dois objetos.
Isso mostra que esses dois objetos herdam propriedades de um outro objeto abstrato, que chamaremos de "PersonTemplate".
**O sufixo _Template é necessário para criar objetos abstratos no Doctrine_
Veja as propriedades deste objeto:
```
# Models/PersonTemplate.php
PersonTemplate:
  columns:
    name:
      type: integer
    birth:
      type: date
    address:
      type: string(255)
    district:
      type: string(255)
    nr:
      type: string(255)
    city_id:
      type: integer
    state_id:
      type: integer
    country_id:
      type: integer
```**

Então os objetos Student e Teacher herdam as propriedades de PersonTemplate. Assim podemos notar uma significativa redução de código:
```
# Models/Student.php
Student:
  actAs: [PersonTemplate]
  columns:
    nr_register:
      type: string(14)
      notnull: true
    course_id:
      type: integer
      notnull: true
# Models/Teacher.php
Teacher:
  actAs: [PersonTemplate]
  columns:
    language_id:
      type: integer
```
Pronto. Agora para todos os outros objetos necessários ao projeto, como "Clients", "Functionary", etc, podem simplesmente herdam as propriedades do objeto abstrato PersonTemplate para receberem automáticamente as propriedades de uma pessoa.

Quanto mais estruturado estiver o projeto, mais organizado e rápido será o desenvolvimento. Ainda no exemplo anterior, o objeto abstrato PersonTemplate possue as propriedades "address, nr, city\_id, state\_id, country\_id" que também podem estar presentes num outro objeto, "Company" por exemplo, assim, poderíamos abstrair essas propriedades e criar um novo objeto abstrato AddressTemplate.

Assim teríamos:
```
PersonTemplate:
  actAs: [AddressTemplate]
... _outras propriedades_
Company:
  actAs: [AddressTemplate]
... _outras propriedades_
```

O Orion Framework possuem muitos objetos abstratos para seus projetos, bastando apenas extende-los em seus models.