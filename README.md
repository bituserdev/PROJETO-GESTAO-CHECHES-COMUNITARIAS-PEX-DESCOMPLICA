


          
# Sistema de Gestão Escolar - Controle de Presença
> Projeto de Extensão - Análise e Desenvolvimento de Sistemas

## 📋 Sobre o Projeto
Sistema web desenvolvido para gerenciamento escolar com foco no controle de presença de alunos, oferecendo uma solução eficiente e moderna para instituições educacionais.

## 🎯 Objetivo
Automatizar e otimizar o processo de controle de frequência escolar, proporcionando uma ferramenta intuitiva para professores e gestores acompanharem o desenvolvimento dos alunos.

## 🚀 Funcionalidades Principais

### 👥 Gestão de Usuários
- Cadastro e gerenciamento de alunos
- Cadastro e gerenciamento de professores
- Níveis de acesso diferenciados (Diretor/Professor)

### ✅ Controle de Presença
- Registro diário de frequência
- Interface intuitiva para marcação
- Filtros por turma e período
- Cálculo automático de percentual de presença

### 📊 Relatórios
- Geração de relatórios detalhados
- Filtros personalizáveis
- Indicadores visuais de frequência
- Exportação de dados

## 💻 Tecnologias Utilizadas

### Backend
- PHP 7+
- MySQL
- PDO para conexão segura com banco de dados

### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- FontAwesome (ícones)

## 🛠️ Requisitos do Sistema

### Servidor
- Apache/Nginx
- PHP 7.0 ou superior
- MySQL 5.7 ou superior
- Extensões PHP necessárias:
  - PDO
  - PDO_MySQL
  - Session

### Cliente
- Navegador web atualizado
- JavaScript habilitado
- Resolução mínima: 1024x768

## 📦 Estrutura do Projeto
```
PROJETO-FACUL/
├── admin/
│   ├── alunos/
│   ├── professores/
│   └── presenca/
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── functions.php
├── config/
│   └── database.php
└── index.php
```

## 🔧 Instalação

1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/sistema-gestao-escolar.git
```

2. Configure o banco de dados
- Importe o arquivo SQL fornecido
- Configure as credenciais em `config/database.php`

3. Configure o servidor web
- Aponte o DocumentRoot para a pasta do projeto
- Certifique-se que o mod_rewrite está habilitado

## 👥 Perfis de Acesso

### Diretor
- Acesso total ao sistema
- Gerenciamento de usuários
- Visualização de todos os relatórios

### Professor
- Registro de presença
- Visualização de relatórios das suas turmas

## 📈 Contribuição para o Ambiente Acadêmico

- Otimização do tempo dos professores
- Redução de erros em registros manuais
- Facilidade no acompanhamento da frequência
- Tomada de decisão baseada em dados
- Conformidade com requisitos educacionais

## 🤝 Contribuição
Contribuições são bem-vindas! Para contribuir:
1. Faça um fork do projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 📄 Licença
Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## ✨ Agradecimentos
- Professores orientadores
- Instituição de ensino
- Colegas de curso
- Comunidade open source

---
Desenvolvido como projeto de extensão para o curso de Análise e Desenvolvimento de Sistemas.

        
