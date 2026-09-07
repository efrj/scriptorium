# Scriptorium

[![PHP](https://img.shields.io/badge/PHP-8.2%2B%20%7C%208.4-777bb4?logo=php&logoColor=white)](https://www.php.net/)
[![Yii3](https://img.shields.io/badge/Framework-Yii%203-0073bb?logo=yii)](https://www.yiiframework.com/)
[![Bootstrap](https://img.shields.io/badge/Frontend-Bootstrap%205.3-7952b3?logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL%20%7C%20SQLite-336791?logo=postgresql&logoColor=white)](https://www.postgresql.org/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

[English](#english) | [Português](#português)

---

<a name="english"></a>
## 📖 English

### Overview
**Scriptorium** is a modern Biblical Study and Reading Platform built with **Yii 3** and **Bootstrap 5.3**. It provides a clean, fast interface for reading the Holy Scriptures, searching passages, and comparing **up to 3 Bible translations simultaneously** in parallel synchronized columns or line-by-line view.

### Included Bible Translations (73 Versions & 2,096,000+ Verses & 73 Books)

#### Portuguese (27 Versions)
1. **[ARIB]** Almeida Revisada Imprensa Bíblica
2. **[ACRF]** Almeida Corrigida e Revisada Fiel
3. **[NVI]** Nova Versão Internacional
4. **[SBB]** Sociedade Bíblica Britânica
5. **[OL]** O Livro
6. **[ARA]** Almeida Revista e Atualizada
7. **[BAM]** Bíblia Católica - Edição Ave Maria (73 books & 33,276 verses)
8. **[ARC69]** Almeida Revista e Corrigida 1969
9. **[ARC09]** Almeida Revista e Corrigida 2009
10. **[NAA]** Nova Almeida Atualizada 2017
11. **[NTLH]** Nova Tradução na Linguagem de Hoje
12. **[NVT]** Nova Versão Transformadora
13. **[AA1848]** Almeida Antiga 1848
14. **[AR]** Almeida Recebida
15. **[KJA]** King James Atualizada
16. **[ACF]** Almeida Corrigida e Fiel 1994
17. **[ARC]** Almeida Revista e Corrigida 1995
18. **[AS21]** Almeida Século 21
19. **[JFAA]** João Ferreira de Almeida Atualizada
20. **[KJF]** King James Fiel
21. **[NBV]** Nova Bíblia Viva 2007
22. **[TB]** Tradução Brasileira
23. **[BLIVRE]** Bíblia Livre
24. **[ALM1911]** Almeida 1911
25. **[MENS]** A Mensagem 2016
26. **[VFL]** Versão Fácil de Ler 2017
27. **[PASTORAL]** Bíblia Sagrada - Edição Pastoral (Católica) (73 books & 35,434 verses)

#### English (12 Versions)
28. **[KJV]** King James Version - Pure Cambridge Edition (complete 31,102 verses)
29. **[ASV]** American Standard Version
30. **[BBE]** Bible in Basic English
31. **[NIV]** New International Version
32. **[BSB]** Berean Standard Bible
33. **[DARBY]** Darby Translation (1890)
34. **[DRA]** Douay-Rheims 1899 American Edition
35. **[OEB-CW]** Open English Bible (Commonwealth)
36. **[OEB-US]** Open English Bible (US Edition)
37. **[WEB]** World English Bible
38. **[WEBBE]** World English Bible (British Edition)
39. **[YLT]** Young's Literal Translation

#### Spanish (4 Versions)
40. **[SPNBES]** La Biblia en Español Sencillo
41. **[SPAPDT]** Palabra de Dios para Ti
42. **[RV1909]** Reina Valera 1909
43. **[SPNVBL]** Versión Biblia Libre

#### Other International Languages (30 Global Translations)
44. **[LUT1912]** German: Luther Bibel (1912)
45. **[OST1996]** French: Ostervald (1996)
46. **[RIV1927]** Italian: Riveduta (1927)
47. **[VULG]** Latin: Clementine Latin Vulgate
48. **[SYNODAL]** Russian: Russian Synodal Translation
49. **[CUV]** Chinese: Chinese Union Version (Traditional)
50. **[CUVS]** Chinese: Chinese Union Version (Simplified)
51. **[KOUGO]** Japanese: Japanese Kougo-yaku (1954/1955)
52. **[KOR]** Korean: Korean Bible
53. **[WLC]** Hebrew: Leningrad Codex (Tanakh/OT)
54. **[STATEN]** Dutch: Statenvertaling (1637)
55. **[BKR]** Czech: Bible Kralická
56. **[DAN]** Danish: Danske Bibel
57. **[SWE]** Swedish: Svenska Bibeln (1917)
58. **[NOR]** Norwegian: Norsk Bibel (1930)
59. **[FIN]** Finnish: Suomalainen Biblia (1776)
60. **[POL]** Polish: Polska Biblia Gdańska (1881)
61. **[HRV]** Croatian: Hrvatska Biblija
62. **[HUN]** Hungarian: Magyar Károli Gáspár Biblia
63. **[RON]** Romanian: Versiunea Dumitru Cornilescu
64. **[BUL]** Bulgarian: Balgarska Bibliya
65. **[SQI]** Albanian: Bibla Shqip
66. **[TGL]** Tagalog: Ang Dating Biblia (1905)
67. **[VIE]** Vietnamese: Bản Dịch Cadman (1934)
68. **[THA]** Thai: Thai Holy Bible
69. **[TUR]** Turkish: Türkçe Kutsal Kitap
70. **[SWA]** Swahili: Swahili New Testament
71. **[LAV]** Latvian: Latviešu Bībele
72. **[MRI]** Maori: Paipera Tapu
73. **[CHR]** Cherokee: Cherokee New Testament

### Key Features
- **Single Reader Mode**: Fast navigation by Version, Book (Old and New Testaments), Chapter, and Verse, with previous/next chapter controls and verse clipboard copy.
- **Multi-Version Comparison Mode**: Compare 1, 2, or 3 translations simultaneously side-by-side or line-by-line.
- **Full Text Search**: Instant search across any translation.
- **Modern UI & Reading Comfort**:
  - Light, Warm Sepia, and Dark Night reading themes.
  - Font size controls (decrease, reset, increase).
  - Fully responsive on mobile, tablet, and desktop.
- **Multi-RDBMS Database Support**:
  - PostgreSQL (Primary/Recommended)
  - SQLite (Ready-to-use local fallback included in `data/bible.sqlite`)
  - MySQL 5.7+
  - ANSI SQL modular dumps included in `resources/sql/*.sql` (74 files)
  - Yii 3 Migrations and Seeder CLI command (`php yii bible/import`).

---

### Quick Start (English)

#### Option 1: Docker (PostgreSQL + App)
```bash
# Clone repository
git clone https://github.com/efrj/scriptorium.git
cd scriptorium

# Start PostgreSQL and App containers
docker compose up -d

# Open in browser
# http://localhost:8080
```

#### Option 2: Local PHP & Built-in SQLite/PostgreSQL
```bash
# Install dependencies
composer install

# (Optional) Seed into your PostgreSQL instance
php yii bible/import

# Run local development server
php -S 127.0.0.1:8080 -t public
# Or via Composer script:
composer run serve
```

---

### Sources & Data Acknowledgments
The biblical texts consolidated in this project were compiled, normalized, and adapted from various open initiatives, public repositories, and biblical data projects:
- **[Githeus/biblia-catolica-sql](https://github.com/Githeus/biblia-catolica-sql)**: Catholic Bible (*Edição Ave Maria*, containing the complete 73 canonical books).
- **[damarals/biblias](https://github.com/damarals/biblias)**: Repository of multiple Portuguese Bible translations.
- **[seven1m/open-bibles](https://github.com/seven1m/open-bibles)**: Repository of public domain and freely licensed international Bible translations in standard XML formats (OSIS, USFX, and Zefania).
- **[Sydney.eti.br (A Bíblia em SQL MySQL em 13 versões)](https://www.sydney.eti.br/a-biblia-em-sql-mysql-em-13-versoes/)**: Consolidated SQL database dump of 13 Portuguese and English Bible translations.

---

### Translation Details & Specific Licenses
Most translations sourced from [open-bibles](https://github.com/seven1m/open-bibles) and classic historical versions are in the **Public Domain**. Below are the specific source and license details for modern translations with specific Creative Commons or open permissions:

- **Hebrew Leningrad Codex (WLC)**:
  - Source: [Tanach.us](http://www.tanach.us/Pages/Technical.html) | [License](http://www.tanach.us/License.html)
  - Notice: *All biblical Hebrew text, in any format, may be viewed or copied without restriction. Version 26.0.*
- **La Biblia en Español Sencillo (SPNBES)**:
  - Source: [eBible SPNBES](https://ebible.org/details.php?id=SPNBES) | License: [CC BY 4.0](https://creativecommons.org/licenses/by/4.0/)
  - Copyright: © 2018 AudioBiblia.org / Irma Flores (`info@audiobiblia.org`).
- **Palabra de Dios para ti (SPAPDT)**:
  - Source: [eBible SPAPDT](https://ebible.org/details.php?id=SPAPDT) | License: [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/)
  - Copyright: © 2017-2022 Asociación Bíblica Latinoamericana.
- **Versión Biblia Libre (SPNVBL)**:
  - Source: [eBible SPNVBL](https://ebible.org/details.php?id=spavbl) | License: [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/)
  - Copyright: © 2018-2020 Jonathan Gallagher y Shelly Barrios de Avila.
- **Berean Standard Bible (BSB)**:
  - Source: [Berean.Bible](https://berean.bible/) (Public Domain dedication / CC0).
- **Open English Bible (OEB-CW & OEB-US)**:
  - Source: [Open English Bible](https://openenglishbible.com/) (Public Domain / CC0).

---

### 🤝 Contributing & Suggestions
Contributions, feedback, and suggestions of any kind are very welcome!
- 💡 Have ideas for new features, additional Bible translations, or UI enhancements?
- 🐛 Found a typo in a verse or a bug in the application?

Feel free to open an **[Issue](https://github.com/efrj/scriptorium/issues)** or submit a **[Pull Request](https://github.com/efrj/scriptorium/pulls)**. All community help to make Scriptorium even better is greatly appreciated!

---

<a name="português"></a>
## 📖 Português

### Visão Geral
**Scriptorium** é uma plataforma moderna para leitura e estudos bíblicos desenvolvida com o framework **Yii 3** e interface responsiva em **Bootstrap 5.3**. Oferece uma experiência fluida para leitura das Sagradas Escrituras, busca por termos/passagens e comparação simultânea de **até 3 versões da Bíblia** em colunas paralelas ou linha a linha.

### Traduções Bíblicas Inclusas (73 Versões, 2.096.000+ Versículos e 73 Livros)

#### Português (27 Versões)
1. **[ARIB]** Almeida Revisada Imprensa Bíblica
2. **[ACRF]** Almeida Corrigida e Revisada Fiel
3. **[NVI]** Nova Versão Internacional
4. **[SBB]** Sociedade Bíblica Britânica
5. **[OL]** O Livro
6. **[ARA]** Almeida Revista e Atualizada
7. **[BAM]** Bíblia Católica - Edição Ave Maria (73 livros e 33.276 versículos)
8. **[ARC69]** Almeida Revista e Corrigida 1969
9. **[ARC09]** Almeida Revista e Corrigida 2009
10. **[NAA]** Nova Almeida Atualizada 2017
11. **[NTLH]** Nova Tradução na Linguagem de Hoje
12. **[NVT]** Nova Versão Transformadora
13. **[AA1848]** Almeida Antiga 1848
14. **[AR]** Almeida Recebida
15. **[KJA]** King James Atualizada
16. **[ACF]** Almeida Corrigida e Fiel 1994
17. **[ARC]** Almeida Revista e Corrigida 1995
18. **[AS21]** Almeida Século 21
19. **[JFAA]** João Ferreira de Almeida Atualizada
20. **[KJF]** King James Fiel
21. **[NBV]** Nova Bíblia Viva 2007
22. **[TB]** Tradução Brasileira
23. **[BLIVRE]** Bíblia Livre
24. **[ALM1911]** Almeida 1911
25. **[MENS]** A Mensagem 2016
26. **[VFL]** Versão Fácil de Ler 2017
27. **[PASTORAL]** Bíblia Sagrada - Edição Pastoral (Católica) (73 livros e 35.434 versículos)

#### Inglês (12 Versões)
28. **[KJV]** King James Version - Pure Cambridge Edition (completa com 31.102 versículos)
29. **[ASV]** American Standard Version
30. **[BBE]** Bible in Basic English
31. **[NIV]** New International Version
32. **[BSB]** Berean Standard Bible
33. **[DARBY]** Darby Translation (1890)
34. **[DRA]** Douay-Rheims 1899 American Edition
35. **[OEB-CW]** Open English Bible (Commonwealth)
36. **[OEB-US]** Open English Bible (US Edition)
37. **[WEB]** World English Bible
38. **[WEBBE]** World English Bible (British Edition)
39. **[YLT]** Young's Literal Translation

#### Espanhol (4 Versões)
40. **[SPNBES]** La Biblia en Español Sencillo
41. **[SPAPDT]** Palabra de Dios para Ti
42. **[RV1909]** Reina Valera 1909
43. **[SPNVBL]** Versión Biblia Libre

#### Outros Idiomas Globais (30 Traduções)
44. **[LUT1912]** Alemão: Luther Bibel (1912)
45. **[OST1996]** Francês: Ostervald (1996)
46. **[RIV1927]** Italiano: Riveduta (1927)
47. **[VULG]** Latim: Clementine Latin Vulgate
48. **[SYNODAL]** Russo: Russian Synodal Translation
49. **[CUV]** Chinês: Chinese Union Version (Tradicional)
50. **[CUVS]** Chinês: Chinese Union Version (Simplificado)
51. **[KOUGO]** Japonês: Japanese Kougo-yaku (1954/1955)
52. **[KOR]** Coreano: Korean Bible
53. **[WLC]** Hebraico: Leningrad Codex (Tanakh/AT)
54. **[STATEN]** Holandês: Statenvertaling (1637)
55. **[BKR]** Tcheco: Bible Kralická
56. **[DAN]** Dinamarquês: Danske Bibel
57. **[SWE]** Sueco: Svenska Bibeln (1917)
58. **[NOR]** Norueguês: Norsk Bibel (1930)
59. **[FIN]** Finlandês: Suomalainen Biblia (1776)
60. **[POL]** Polonês: Polska Biblia Gdańska (1881)
61. **[HRV]** Croata: Hrvatska Biblija
62. **[HUN]** Húngaro: Magyar Károli Gáspár Biblia
63. **[RON]** Romeno: Versiunea Dumitru Cornilescu
64. **[BUL]** Búlgaro: Balgarska Bibliya
65. **[SQI]** Albanês: Bibla Shqip
66. **[TGL]** Tagalo: Ang Dating Biblia (1905)
67. **[VIE]** Vietnamita: Bản Dịch Cadman (1934)
68. **[THA]** Tailandês: Thai Holy Bible
69. **[TUR]** Turco: Türkçe Kutsal Kitap
70. **[SWA]** Suaíli: Swahili New Testament
71. **[LAV]** Letão: Latviešu Bībele
72. **[MRI]** Maori: Paipera Tapu
73. **[CHR]** Cherokee: Cherokee New Testament

### Principais Recursos
- **Modo Leitor Individual**: Navegação rápida por Tradução, Livro (Antigo e Novo Testamento), Capítulo e Versículo, botões de capítulo anterior/próximo e cópia de versículo com referência formatada.
- **Modo Comparador Multi-Versão**: Comparação simultânea de 1, 2 ou 3 traduções bíblicas em colunas paralelas ou versículo a versículo.
- **Busca Textual**: Pesquisa rápida de termos e frases em qualquer uma das versões bíblicas.
- **Interface e Conforto de Leitura**:
  - Temas Claro, Sépia e Noturno.
  - Ajuste dinâmico de tamanho de fonte.
  - Totalmente responsivo para Desktop, Tablets e Smartphones.
- **Compatibilidade Multi-Banco (PostgreSQL, MySQL e SQLite)**:
  - Banco de Dados PostgreSQL nativo.
  - Banco SQLite local incluído e pré-gerado em `data/bible.sqlite`.
  - Dumps SQL ANSI modulares por versão em `resources/sql/*.sql` (74 arquivos).
  - Migrações do Yii 3 e comando de Seeder (`php yii bible/import`).

---

### Fontes e Agradecimentos
Os textos bíblicos consolidados neste projeto foram compilados, normalizados e integrados a partir de diversas iniciativas abertas, repositórios públicos e projetos de dados bíblicos:
- **[Githeus/biblia-catolica-sql](https://github.com/Githeus/biblia-catolica-sql)**: Bíblia Católica (Edição Ave Maria, contendo os 73 livros canônicos).
- **[damarals/biblias](https://github.com/damarals/biblias)**: Repositório aberto de diversas traduções da Bíblia em português.
- **[seven1m/open-bibles](https://github.com/seven1m/open-bibles)**: Repositório de traduções internacionais da Bíblia em domínio público e licenças livres (formatos XML OSIS, USFX e Zefania).
- **[Sydney.eti.br (A Bíblia em SQL MySQL em 13 versões)](https://www.sydney.eti.br/a-biblia-em-sql-mysql-em-13-versoes/)**: Dump SQL consolidado com 13 versões da Bíblia em português e inglês.

---

### Detalhes das Traduções e Licenças Específicas
A maioria das traduções históricas e provenientes do projeto [open-bibles](https://github.com/seven1m/open-bibles) está em **Domínio Público**. Abaixo estão os detalhes de fontes e termos de licença das versões com licenças Creative Commons ou termos específicos:

- **Hebrew Leningrad Codex (WLC)**:
  - Fonte: [Tanach.us](http://www.tanach.us/Pages/Technical.html) | [Licença](http://www.tanach.us/License.html)
  - Nota: *Todo o texto bíblico em hebraico pode ser visualizado ou copiado sem restrições. Versão 26.0.*
- **La Biblia en Español Sencillo (SPNBES)**:
  - Fonte: [eBible SPNBES](https://ebible.org/details.php?id=SPNBES) | Licença: [CC BY 4.0](https://creativecommons.org/licenses/by/4.0/)
  - Copyright: © 2018 AudioBiblia.org / Irma Flores (`info@audiobiblia.org`).
- **Palabra de Dios para ti (SPAPDT)**:
  - Fonte: [eBible SPAPDT](https://ebible.org/details.php?id=SPAPDT) | Licença: [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/)
  - Copyright: © 2017-2022 Asociación Bíblica Latinoamericana.
- **Versión Biblia Libre (SPNVBL)**:
  - Fonte: [eBible SPNVBL](https://ebible.org/details.php?id=spavbl) | Licença: [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/)
  - Copyright: © 2018-2020 Jonathan Gallagher y Shelly Barrios de Avila.
- **Berean Standard Bible (BSB)**:
  - Fonte: [Berean.Bible](https://berean.bible/) (Dedicação em Domínio Público / CC0).
- **Open English Bible (OEB-CW & OEB-US)**:
  - Fonte: [Open English Bible](https://openenglishbible.com/) (Domínio Público / CC0).

---

### Como Executar (Português)

#### Opção 1: Via Docker (PostgreSQL + Aplicação)
```bash
# Clonar o repositório
git clone https://github.com/efrj/scriptorium.git
cd scriptorium

# Subir os serviços
docker compose up -d

# Acessar no navegador:
# http://localhost:8080
```

#### Opção 2: Localmente via PHP (SQLite ou PostgreSQL)
```bash
# Instalar dependências
composer install

# (Opcional) Importar/Semear dados no seu banco PostgreSQL
php yii bible/import

# Iniciar o servidor local
php -S 127.0.0.1:8080 -t public
# Ou:
composer run serve
```

---

### 🤝 Contribuições e Sugestões
Toda sugestão, melhoria, correção e contribuição para com o projeto é muito bem-vinda!
- 💡 Tem ideias para novos recursos, inclusão de novas traduções da Bíblia ou melhorias de interface?
- 🐛 Encontrou algum erro de digitação em algum versículo ou comportamento inesperado na aplicação?

Sinta-se à vontade para abrir uma **[Issue](https://github.com/efrj/scriptorium/issues)** ou enviar um **[Pull Request](https://github.com/efrj/scriptorium/pulls)**. Toda ajuda da comunidade para tornar o Scriptorium ainda melhor é imensamente apreciada!

---

## 🏛️ Architecture & Database Structure (Estrutura do Banco)

### Tables (Tabelas em Inglês)
- **`testaments`**: `id`, `name`, `name_pt`
- **`books`**: `id`, `testament_id`, `position`, `name`, `abbreviation`, `name_pt`, `abbreviation_pt`, `chapters_count`
- **`versions`**: `id`, `code`, `name`, `language`
- **`verses`**: `id`, `version_id`, `book_id`, `chapter`, `verse`, `text`

---

## 📄 License
Este projeto é distribuído sob a licença [MIT](LICENSE).
