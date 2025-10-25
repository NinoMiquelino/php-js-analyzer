## 👨‍💻 Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/ninomiquelino" width="100" height="100" style="border-radius: 50%">
  <br>
  <strong>Onivaldo Miquelino</strong>
  <br>
  <a href="https://github.com/ninomiquelino">@ninomiquelino</a>
</div>

---

# 🖼️ Upload e Análise de Imagens Assíncrono (PHP/JS Full Stack)

![Made with PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Frontend JavaScript](https://img.shields.io/badge/Frontend-JavaScript-F7DF1E?logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-38B2AC?logo=tailwindcss&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-green)
![Status Stable](https://img.shields.io/badge/Status-Stable-success)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-blue)
![GitHub stars](https://img.shields.io/github/stars/NinoMiquelino/php-js-analyzer?style=social)
![GitHub forks](https://img.shields.io/github/forks/NinoMiquelino/php-js-analyzer?style=social)
![GitHub issues](https://img.shields.io/github/issues/NinoMiquelino/php-js-analyzer)

Este projeto demonstra a capacidade de construir um pipeline de processamento de arquivos robusto, onde o frontend utiliza JavaScript assíncrono avançado para gerenciar uploads paralelos, e o backend (PHP POO) lida com o processamento intensivo de imagens.

---

## ✨ Destaques do Projeto

* **PHP POO (GD Library):** A classe `ImageAnalyzer` encapsula toda a complexidade de manipulação de imagens, incluindo a verificação de MIME Type e a geração de thumbnails com a biblioteca GD.
* **JavaScript Assíncrono Paralelo:** O frontend utiliza a função `Promise.allSettled()` para iniciar múltiplas requisições `fetch` simultaneamente, processando a fila de uploads sem travar a UI.
* **Gestão de Estado Visual:** O JavaScript gerencia e exibe o status de cada arquivo individualmente (Aguardando, Processando, Sucesso, Falha), fornecendo uma experiência de usuário moderna e responsiva.
* **Comunicação Assíncrona:** O backend retorna metadados detalhados (dimensões, tamanho) para cada arquivo, que são exibidos dinamicamente no frontend.

---

## 🧠 Tecnologias utilizadas

* **Backend:** PHP 7.4+ (POO, Manipulação de Arquivos, GD Library).
* **Frontend:** HTML5, JavaScript Vanilla (fetch, Promises, Event Handlers) e Tailwind CSS.

---

## 🧩 Estrutura do Projeto

```
php-js-analyzer/
├── index.html
├── README.md
├── .gitignore
└── 📁 src/
         ├── ImageAnalyzer.php
         ├── api.php
         ├── 📁 uploads/
         └── 📁 thumbs/        
```
---

## ⚙️ Configuração e Instalação

### Pré-requisitos

1.  Um ambiente de servidor web com PHP.
2.  A **extensão GD Library** deve estar habilitada no seu `php.ini` (`extension=gd`).
3.  Permissão de escrita nas pastas `src/uploads/` e `src/thumbs/`.

### Execução

1.  Crie a estrutura de pastas.
2.  Crie os diretórios de imagens: `mkdir src/uploads` e `mkdir src/thumbs`.
3.  Execute o servidor embutido do PHP (a partir da raiz do projeto):

    ```bash
    php -S localhost:8001
    ```

4.  Acesse: `http://localhost:8001/public/index.html`.

---

## 📝 Instruções de Uso

1.  **Selecione Múltiplos Arquivos:** Use o campo de input para selecionar 3 ou mais arquivos JPG ou PNG.
2.  **Processar:** Clique no botão "Processar e Analisar Arquivos Selecionados".
3.  **Observe o Fluxo:**
    * O JavaScript inicia as chamadas `POST` para `src/api.php` para cada arquivo.
    * O status de cada arquivo muda para "Processando...".
    * O PHP salva o arquivo original, gera um thumbnail de 200px e retorna os metadados.
    * Ao retornar o status de sucesso, o frontend exibe o thumbnail gerado, as dimensões e o tamanho final do arquivo.
    * Tente selecionar um arquivo não suportado (ex: PDF); o PHP deve retornar um erro 400 que será exibido no frontend.

---

## 🤝 Contribuições
Contribuições são sempre bem-vindas!  
Sinta-se à vontade para abrir uma [*issue*](https://github.com/NinoMiquelino/php-js-analyzer/issues) com sugestões ou enviar um [*pull request*](https://github.com/NinoMiquelino/php-js-analyzer/pulls) com melhorias.

---

## 💬 Contato
📧 [Entre em contato pelo LinkedIn](https://www.linkedin.com/in/onivaldomiquelino/)  
💻 Desenvolvido por **Onivaldo Miquelino**

---
