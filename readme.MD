# Projeto: Sistema de Gerenciamento via Terminal

## Enunciado

Crie um sistema de gerenciamento que rode no terminal usando PHP puro (sem frameworks). O sistema deve ter um **menu interativo** com as seguintes funcionalidades:

- **Cadastrar** um novo registro com pelo menos 4 campos (sendo pelo menos 1 string, 1 inteiro e 1 booleano)
- **Listar** todos os registros cadastrados, ordenados alfabeticamente
- **Buscar** registros por nome (busca parcial e case-insensitive)
- **Editar** um registro existente (permitindo manter valores atuais ao pressionar Enter)
- **Remover** um registro com confirmação antes de excluir
- **Estatísticas** — exibir pelo menos 3 informações calculadas a partir dos dados (ex: total, média, contagem por status)

### Regras

1. Os dados devem ser armazenados em um **array de arrays associativos**
2. Cada registro deve ter um **ID único** gerado automaticamente
3. Todos os inputs do usuário devem ser **validados** antes de salvar
4. O código deve ser separado em **dois arquivos**: um para as funções e outro para o loop principal
5. O menu deve rodar em **loop infinito** até o usuário escolher sair

### Exemplos de temas

Você pode criar um sistema de gerenciamento para qualquer tema. Alguns exemplos:

- Contatos (nome, email, telefone, idade)
- Livros (titulo, autor, paginas, lido/nao lido)
- Tarefas (descricao, prioridade, prazo, concluida)
- Produtos (nome, preco, quantidade, disponivel)
- Alunos (nome, matricula, nota, aprovado)

Escolha um tema diferente do exemplo dado em aula.

---

## Descricao do Projeto de Referencia

Sistema de Gerenciamento de Contatos via terminal. O usuario interage com um menu numerado para cadastrar, listar, buscar, editar e remover contatos. Os dados sao persistidos em um arquivo JSON (`contatos.json`).

### Estrutura de Arquivos

```
projects/
  index.php      -> Loop principal e menu (require das funcoes)
  funcoes.php    -> Todas as funcoes do sistema
  contatos.json  -> Arquivo de persistencia dos contatos
```

### Tecnologias e Conceitos Aplicados

| Topico | Como foi usado |
|---|---|
| Sintaxe basica | `echo` para saida, `readline()` para input do usuario |
| Tipos de dados | `string` (nome, email, telefone), `int` (idade, ID), `bool` (ativo/inativo) |
| Variaveis | `$contatos` (array principal), `$contadorId` (gerador de IDs), `$opcao` (controle do menu), `$arquivoContatos` (caminho do JSON) |
| Operadores | Comparacao (`===`, `>`, `<=`) para validacoes, concatenacao para exibir dados, aritmeticos para IDs e media |
| Estruturas de controle | `switch` para o menu, `if/else` para validacoes (email, telefone, idade, existencia do contato) |
| Estruturas de repeticao | `while(true)` para o loop do menu, `foreach` para percorrer contatos |
| Funcoes | Cada acao em funcao separada: `cadastrarContato()`, `listarContatos()`, `buscarContato()`, `editarContato()`, `removerContato()`, `exibirEstatisticas()`, `carregarContatos()`, `salvarContatos()` |
| Manipulacao de arquivos | `file_exists()`, `file_get_contents()`, `file_put_contents()` para persistencia em JSON |
| Passagem por referencia | `&$contatos` e `&$contador` para modificar arrays e variaveis dentro das funcoes |
| Type hints | Tipos nos parametros (`string`, `array`, `int`, `bool`) e retorno (`: void`, `: string`, `: int`, `: bool`) |

### Funcoes Nativas Utilizadas

| Funcao | Onde foi usada |
|---|---|
| `trim()` | Limpar espacos dos inputs |
| `strtolower()` | Busca case-insensitive |
| `ucwords()` | Formatar nomes na listagem |
| `str_contains()` | Busca parcial por nome |
| `strlen()` | Validacao de email e telefone |
| `array_push()` | Adicionar contato ao array |
| `array_filter()` | Filtrar contatos na busca e contar ativos |
| `array_values()` | Reindexar array apos remocao |
| `count()` | Total de contatos e estatisticas |
| `usort()` | Ordenar contatos por nome |
| `strcmp()` | Comparacao de strings na ordenacao |
| `number_format()` | Formatar media de idade |
| `unset()` | Remover contato do array |
| `file_exists()` | Verificar se o arquivo JSON existe antes de carregar |
| `file_get_contents()` | Ler o conteudo do arquivo JSON |
| `file_put_contents()` | Salvar contatos no arquivo JSON |
| `json_decode()` | Converter JSON para array PHP |
| `json_encode()` | Converter array PHP para JSON |
| `array_column()` | Extrair coluna de IDs para calcular proximo ID |
| `max()` | Encontrar o maior ID existente |

### Menu do Sistema

```
========================================
   GERENCIAMENTO DE CONTATOS
========================================
 [1] Cadastrar contato
 [2] Listar contatos
 [3] Buscar contato
 [4] Editar contato
 [5] Remover contato
 [6] Estatisticas
 [0] Sair
========================================
```
