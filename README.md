# 🎓 Sistema de Gestão Escolar - Controle de Presença

> Projeto de Extensão – Curso de Análise e Desenvolvimento de Sistemas  
> **Instituição:** Descomplica Faculdades

<p align="center">
  <img src="https://tse2.mm.bing.net/th/id/OIP.tFUSM6b7aekTnDALuzW7vQHaD4?rs=1&pid=ImgDetMain" alt="Descomplica Faculdades" width="300"/>
</p>

<p align="center">
  <img src="https://komarev.com/ghpvc/?username=bituserdev&label=Visualiza%C3%A7%C3%B5es&color=blue&style=for-the-badge"/>
</p>

---

## 📋 Sobre o Projeto

Sistema web desenvolvido com foco no **gerenciamento escolar**, oferecendo uma solução moderna e eficiente para o **controle de presença dos alunos** com visualizações gráficas, relatórios exportáveis, gestão de usuários e muito mais.

🔒 **Uso exclusivo para fins educacionais.**  
🚫 **É expressamente proibida a venda ou comercialização deste sistema.**

---

## 🎯 Objetivo

Automatizar e otimizar o processo de controle de frequência escolar, fornecendo uma ferramenta intuitiva para professores e gestores acompanharem o desenvolvimento acadêmico dos alunos.

---

## 🚀 Funcionalidades Principais

### 👥 Gestão de Usuários
- Cadastro e gerenciamento de **alunos**
- Cadastro e gerenciamento de **professores**
- Níveis de acesso distintos: **Diretor** e **Professor**

### ✅ Controle de Presença
- Registro diário de presença
- Interface prática para marcação
- Filtros por **turma** e **período**
- Cálculo automático do percentual de presença

### 📊 Relatórios e Gráficos
- Geração de relatórios detalhados
- Filtros personalizáveis
- Indicadores visuais de frequência
- Gráficos de barras e pizza (Chart.js)
- Exportação de dados (.xls/.csv)

### 📈 Painel Administrativo
- Dashboard com contagem de alunos, professores e presenças
- Visualizações rápidas em cards com ícones
- Indicadores de desempenho escolar

---

## 💻 Tecnologias Utilizadas

### Backend
- PHP 7+
- MySQL
- PDO (acesso seguro ao banco de dados)

### Frontend
- HTML5 / CSS3
- JavaScript
- Bootstrap 5
- FontAwesome (ícones)
- Chart.js (gráficos)

---

## 🛠️ Requisitos do Sistema

### Servidor
- Apache ou Nginx
- PHP 7.0 ou superior
- MySQL 5.7+
- Extensões PHP:
  - `PDO`
  - `PDO_MySQL`
  - `Session`

### Cliente
- Navegador moderno e atualizado
- JavaScript habilitado
- Resolução mínima: 1024x768

---

## 📁 Estrutura do Projeto

```
sistema-gestao-escolar/
├── admin/
│   ├── alunos/
│   ├── professores/
│   ├── presenca/
│   └── dashboard.php
├── assets/
│   ├── css/
│   ├── js/
│   ├── img/
│   └── charts/
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── functions.php
├── config/
│   └── database.php
├── sql/
│   └── estrutura.sql
└── index.php
```

---

## ⚙️ Instalação

1. **Clone o repositório**
```bash
git clone https://github.com/bituserdev/sistema-gestao-escolar.git
```

2. **Configure o banco de dados**
   - Importe o arquivo `estrutura.sql` (na pasta `/sql`)
   - Edite o arquivo `config/database.php` com suas credenciais

3. **Configure o servidor web**
   - Aponte o `DocumentRoot` para a pasta do projeto
   - Certifique-se de que o módulo `mod_rewrite` esteja habilitado (caso use Apache)

---

## 👤 Perfis de Acesso

### 🧑‍💼 Diretor
- Acesso total ao sistema
- Gerenciamento de todos os usuários
- Visualização completa dos relatórios

### 👨‍🏫 Professor
- Registro de presença
- Acesso aos relatórios das turmas atribuídas

---

## 📈 Benefícios Acadêmicos

- Otimização do tempo dos professores  
- Redução de erros em registros manuais  
- Facilidade no acompanhamento da frequência escolar  
- Apoio à tomada de decisão com base em dados  
- Conformidade com requisitos educacionais  
- Visualização intuitiva com gráficos e relatórios

---

## 🤝 Como Contribuir

1. Faça um fork do repositório  
2. Crie uma nova branch com a sua feature: `git checkout -b minha-feature`  
3. Commit suas alterações: `git commit -m 'feat: minha nova funcionalidade'`  
4. Faça push para a branch: `git push origin minha-feature`  
5. Abra um Pull Request 🚀

---

## 📄 Licença

Este projeto está licenciado sob a licença [MIT](LICENSE).  
Distribuição autorizada **somente para fins acadêmicos**.

---

## ✨ Agradecimentos

- Professores e orientadores  
- Instituição Descomplica Faculdades  
- Colegas do curso de ADS  
- Comunidade open source 💚

---

Desenvolvido como projeto de extensão do curso **Análise e Desenvolvimento de Sistemas**.
