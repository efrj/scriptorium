-- ====================================================================
-- Holy Bible Database Schema, Books & Versions (73 Versions, 73 Books)
-- Compatible with: PostgreSQL, MySQL 5.7+, SQLite 3
-- ====================================================================

-- Universal Schema for Holy Bible Database
-- Compatible with PostgreSQL, MySQL, and SQLite

DROP TABLE IF EXISTS verses;
DROP TABLE IF EXISTS versions;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS testaments;

CREATE TABLE IF NOT EXISTS testaments (
    id INTEGER PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    name_pt VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY,
    testament_id INTEGER NOT NULL,
    position INTEGER NOT NULL,
    name VARCHAR(100) NOT NULL,
    abbreviation VARCHAR(10) NOT NULL,
    name_pt VARCHAR(100) NOT NULL,
    abbreviation_pt VARCHAR(10) NOT NULL,
    chapters_count INTEGER DEFAULT 0
);

CREATE TABLE IF NOT EXISTS versions (
    id INTEGER PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    name VARCHAR(150) NOT NULL,
    language VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS verses (
    id INTEGER PRIMARY KEY,
    version_id INTEGER NOT NULL,
    book_id INTEGER NOT NULL,
    chapter INTEGER NOT NULL,
    verse INTEGER NOT NULL,
    text TEXT NOT NULL
);

CREATE INDEX IF NOT EXISTS idx_verses_lookup ON verses(version_id, book_id, chapter, verse);
CREATE INDEX IF NOT EXISTS idx_verses_version_book ON verses(version_id, book_id);
CREATE INDEX IF NOT EXISTS idx_verses_book_chap ON verses(book_id, chapter, verse);

INSERT INTO testaments (id, name, name_pt) VALUES (1, 'Old Testament', 'Antigo Testamento');
INSERT INTO testaments (id, name, name_pt) VALUES (2, 'New Testament', 'Novo Testamento');

INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (1, 1, 1, 'Genesis', 'Gen', 'Gênesis', 'gn', 50);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (2, 1, 2, 'Exodus', 'Exo', 'Êxodo', 'ex', 40);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (3, 1, 3, 'Leviticus', 'Lev', 'Levítico', 'lv', 27);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (4, 1, 4, 'Numbers', 'Num', 'Números', 'nm', 36);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (5, 1, 5, 'Deuteronomy', 'Deu', 'Deuteronômio', 'dt', 34);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (6, 1, 6, 'Joshua', 'Jos', 'Josué', 'js', 24);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (7, 1, 7, 'Judges', 'Jdg', 'Juízes', 'jz', 21);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (8, 1, 8, 'Ruth', 'Rth', 'Rute', 'rt', 4);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (9, 1, 9, '1 Samuel', '1Sa', '1 Samuel', '1sm', 31);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (10, 1, 10, '2 Samuel', '2Sa', '2 Samuel', '2sm', 24);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (11, 1, 11, '1 Kings', '1Ki', '1 Reis', '1rs', 22);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (12, 1, 12, '2 Kings', '2Ki', '2 Reis', '2rs', 25);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (13, 1, 13, '1 Chronicles', '1Ch', '1 Crônicas', '1cr', 29);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (14, 1, 14, '2 Chronicles', '2Ch', '2 Crônicas', '2cr', 36);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (15, 1, 15, 'Ezra', 'Ezr', 'Esdras', 'ed', 10);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (16, 1, 16, 'Nehemiah', 'Neh', 'Neemias', 'ne', 13);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (17, 1, 17, 'Esther', 'Est', 'Ester', 'et', 10);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (18, 1, 18, 'Job', 'Job', 'Jó', 'jó', 42);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (19, 1, 19, 'Psalms', 'Psa', 'Salmos', 'sl', 150);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (20, 1, 20, 'Proverbs', 'Pro', 'Provérbios', 'pv', 31);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (21, 1, 21, 'Ecclesiastes', 'Ecc', 'Eclesiastes', 'ec', 12);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (22, 1, 22, 'Song of Solomon', 'Sol', 'Cânticos', 'ct', 8);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (23, 1, 23, 'Isaiah', 'Isa', 'Isaías', 'is', 66);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (24, 1, 24, 'Jeremiah', 'Jer', 'Jeremias', 'jr', 52);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (25, 1, 25, 'Lamentations', 'Lam', 'Lamentações', 'lm', 5);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (26, 1, 26, 'Ezekiel', 'Eze', 'Ezequiel', 'ez', 48);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (27, 1, 27, 'Daniel', 'Dan', 'Daniel', 'dn', 14);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (28, 1, 28, 'Hosea', 'Hos', 'Oséias', 'os', 14);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (29, 1, 29, 'Joel', 'Joe', 'Joel', 'jl', 3);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (30, 1, 30, 'Amos', 'Amo', 'Amós', 'am', 9);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (31, 1, 31, 'Obadiah', 'Oba', 'Obadias', 'ob', 1);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (32, 1, 32, 'Jonah', 'Jon', 'Jonas', 'jn', 4);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (33, 1, 33, 'Micah', 'Mic', 'Miquéias', 'mq', 7);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (34, 1, 34, 'Nahum', 'Nah', 'Naum', 'na', 3);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (35, 1, 35, 'Habakkuk', 'Hab', 'Habacuque', 'hc', 3);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (36, 1, 36, 'Zephaniah', 'Zep', 'Sofonias', 'sf', 3);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (37, 1, 37, 'Haggai', 'Hag', 'Ageu', 'ag', 2);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (38, 1, 38, 'Zechariah', 'Zec', 'Zacarias', 'zc', 14);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (39, 1, 39, 'Malachi', 'Mal', 'Malaquias', 'ml', 4);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (40, 2, 1, 'Matthew', 'Mat', 'Mateus', 'mt', 28);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (41, 2, 2, 'Mark', 'Mar', 'Marcos', 'mc', 16);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (42, 2, 3, 'Luke', 'Luk', 'Lucas', 'lc', 24);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (43, 2, 4, 'John', 'Joh', 'João', 'jo', 21);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (44, 2, 5, 'Acts', 'Act', 'Atos', 'at', 28);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (45, 2, 6, 'Romans', 'Rom', 'Romanos', 'rm', 16);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (46, 2, 7, '1 Corinthians', '1Co', '1 Coríntios', '1co', 16);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (47, 2, 8, '2 Corinthians', '2Co', '2 Coríntios', '2co', 13);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (48, 2, 9, 'Galatians', 'Gal', 'Gálatas', 'gl', 6);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (49, 2, 10, 'Ephesians', 'Eph', 'Efésios', 'ef', 6);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (50, 2, 11, 'Philippians', 'Php', 'Filipenses', 'fp', 4);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (51, 2, 12, 'Colossians', 'Col', 'Colossenses', 'cl', 4);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (52, 2, 13, '1 Thessalonians', '1Th', '1 Tessalonicenses', '1ts', 5);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (53, 2, 14, '2 Thessalonians', '2Th', '2 Tessalonicenses', '2ts', 3);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (54, 2, 15, '1 Timothy', '1Ti', '1 Timóteo', '1tm', 6);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (55, 2, 16, '2 Timothy', '2Ti', '2 Timóteo', '2tm', 4);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (56, 2, 17, 'Titus', 'Tit', 'Tito', 'tt', 3);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (57, 2, 18, 'Philemon', 'Phm', 'Filemom', 'fm', 1);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (58, 2, 19, 'Hebrews', 'Heb', 'Hebreus', 'hb', 13);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (59, 2, 20, 'James', 'Jas', 'Tiago', 'tg', 5);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (60, 2, 21, '1 Peter', '1Pe', '1 Pedro', '1pe', 5);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (61, 2, 22, '2 Peter', '2Pe', '2 Pedro', '2pe', 3);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (62, 2, 23, '1 John', '1Jo', '1 João', '1jo', 5);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (63, 2, 24, '2 John', '2Jo', '2 João', '2jo', 1);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (64, 2, 25, '3 John', '3Jo', '3 João', '3jo', 1);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (65, 2, 26, 'Jude', 'Jud', 'Judas', 'jd', 1);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (66, 2, 27, 'Revelation', 'Rev', 'Apocalipse', 'ap', 22);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (67, 1, 40, 'Tobit', 'Tob', 'Tobias', 'tb', 14);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (68, 1, 41, 'Judith', 'Jdt', 'Judite', 'jdt', 16);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (69, 1, 42, '1 Maccabees', '1Mc', '1 Macabeus', '1mc', 16);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (70, 1, 43, '2 Maccabees', '2Mc', '2 Macabeus', '2mc', 15);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (71, 1, 44, 'Wisdom of Solomon', 'Wis', 'Sabedoria', 'sb', 19);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (72, 1, 45, 'Sirach', 'Sir', 'Eclesiástico', 'eclo', 51);
INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (73, 1, 46, 'Baruch', 'Bar', 'Baruc', 'br', 6);

INSERT INTO versions (id, code, name, language) VALUES (1, 'ARIB', 'Almeida Revisada Imprensa Bíblica', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (2, 'ACRF', 'Almeida Corrigida e Revisada Fiel', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (3, 'NVI', 'Nova Versão Internacional', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (4, 'SBB', 'Sociedade Bíblica Britânica', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (5, 'OL', 'O Livro', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (6, 'ARA', 'Almeida Revista e Atualizada', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (7, 'ASV', 'American Standard Version', 'en');
INSERT INTO versions (id, code, name, language) VALUES (8, 'KJV', 'King James Version (Pure Cambridge Edition)', 'en');
INSERT INTO versions (id, code, name, language) VALUES (9, 'BAM', 'Bíblia Católica (Ave Maria)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (10, 'ARC69', 'Almeida Revista e Corrigida (1969)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (11, 'ARC09', 'Almeida Revista e Corrigida (2009)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (12, 'NAA', 'Nova Almeida Atualizada (2017)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (13, 'NTLH', 'Nova Tradução na Linguagem de Hoje', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (14, 'NVT', 'Nova Versão Transformadora', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (15, 'AA1848', 'Almeida Antiga (1848)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (16, 'AR', 'Almeida Recebida', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (17, 'KJA', 'King James Atualizada', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (18, 'BBE', 'Bible in Basic English', 'en');
INSERT INTO versions (id, code, name, language) VALUES (19, 'NIV', 'New International Version', 'en');
INSERT INTO versions (id, code, name, language) VALUES (20, 'ACF', 'Almeida Corrigida e Fiel (1994)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (21, 'ARC', 'Almeida Revista e Corrigida (1995)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (22, 'AS21', 'Almeida Século 21', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (23, 'JFAA', 'João Ferreira de Almeida Atualizada', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (24, 'KJF', 'King James Fiel', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (25, 'NBV', 'Nova Bíblia Viva', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (26, 'TB', 'Tradução Brasileira', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (27, 'BLIVRE', 'Bíblia Livre', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (28, 'ALM1911', 'Almeida (1911)', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (29, 'MENS', 'A Mensagem', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (30, 'VFL', 'Versão Fácil de Ler', 'pt');
INSERT INTO versions (id, code, name, language) VALUES (31, 'BSB', 'Berean Standard Bible', 'en');
INSERT INTO versions (id, code, name, language) VALUES (32, 'DARBY', 'Darby Translation (1890)', 'en');
INSERT INTO versions (id, code, name, language) VALUES (33, 'DRA', 'Douay-Rheims 1899 American Edition', 'en');
INSERT INTO versions (id, code, name, language) VALUES (34, 'OEB-CW', 'Open English Bible (Commonwealth)', 'en');
INSERT INTO versions (id, code, name, language) VALUES (35, 'OEB-US', 'Open English Bible (US Edition)', 'en');
INSERT INTO versions (id, code, name, language) VALUES (36, 'WEB', 'World English Bible', 'en');
INSERT INTO versions (id, code, name, language) VALUES (37, 'WEBBE', 'World English Bible (British Edition)', 'en');
INSERT INTO versions (id, code, name, language) VALUES (38, 'YLT', 'Young''s Literal Translation', 'en');
INSERT INTO versions (id, code, name, language) VALUES (39, 'SPNBES', 'La Biblia en Español Sencillo', 'es');
INSERT INTO versions (id, code, name, language) VALUES (40, 'SPAPDT', 'Palabra de Dios para Ti', 'es');
INSERT INTO versions (id, code, name, language) VALUES (41, 'RV1909', 'Reina Valera 1909', 'es');
INSERT INTO versions (id, code, name, language) VALUES (42, 'SPNVBL', 'Versión Biblia Libre', 'es');
INSERT INTO versions (id, code, name, language) VALUES (43, 'LUT1912', 'Luther Bibel (1912)', 'de');
INSERT INTO versions (id, code, name, language) VALUES (44, 'OST1996', 'French Ostervald (1996)', 'fr');
INSERT INTO versions (id, code, name, language) VALUES (45, 'RIV1927', 'Italian Riveduta (1927)', 'it');
INSERT INTO versions (id, code, name, language) VALUES (46, 'VULG', 'Clementine Latin Vulgate', 'la');
INSERT INTO versions (id, code, name, language) VALUES (47, 'SYNODAL', 'Russian Synodal Translation', 'ru');
INSERT INTO versions (id, code, name, language) VALUES (48, 'CUV', 'Chinese Union Version (Traditional)', 'zh');
INSERT INTO versions (id, code, name, language) VALUES (49, 'CUVS', 'Chinese Union Version (Simplified)', 'zh');
INSERT INTO versions (id, code, name, language) VALUES (50, 'KOUGO', 'Japanese Kougo-yaku (1954/1955)', 'ja');
INSERT INTO versions (id, code, name, language) VALUES (51, 'KOR', 'Korean Bible', 'ko');
INSERT INTO versions (id, code, name, language) VALUES (52, 'WLC', 'Hebrew Leningrad Codex (Tanakh)', 'he');
INSERT INTO versions (id, code, name, language) VALUES (53, 'STATEN', 'Dutch Statenvertaling (1637)', 'nl');
INSERT INTO versions (id, code, name, language) VALUES (54, 'BKR', 'Czech Bible Kralická', 'cs');
INSERT INTO versions (id, code, name, language) VALUES (55, 'DAN', 'Danske Bibel', 'da');
INSERT INTO versions (id, code, name, language) VALUES (56, 'SWE', 'Svenska Bibeln (1917)', 'sv');
INSERT INTO versions (id, code, name, language) VALUES (57, 'NOR', 'Norsk Bibel (1930)', 'no');
INSERT INTO versions (id, code, name, language) VALUES (58, 'FIN', 'Suomalainen Biblia (1776)', 'fi');
INSERT INTO versions (id, code, name, language) VALUES (59, 'POL', 'Polska Biblia Gdańska (1881)', 'pl');
INSERT INTO versions (id, code, name, language) VALUES (60, 'HRV', 'Hrvatska Biblija', 'hr');
INSERT INTO versions (id, code, name, language) VALUES (61, 'HUN', 'Magyar Károli Gáspár Biblia', 'hu');
INSERT INTO versions (id, code, name, language) VALUES (62, 'RON', 'Versiunea Dumitru Cornilescu', 'ro');
INSERT INTO versions (id, code, name, language) VALUES (63, 'BUL', 'Balgarska Bibliya', 'bg');
INSERT INTO versions (id, code, name, language) VALUES (64, 'SQI', 'Bibla Shqip', 'sq');
INSERT INTO versions (id, code, name, language) VALUES (65, 'TGL', 'Ang Dating Biblia (1905)', 'tl');
INSERT INTO versions (id, code, name, language) VALUES (66, 'VIE', 'Bản Dịch Cadman (1934)', 'vi');
INSERT INTO versions (id, code, name, language) VALUES (67, 'THA', 'Thai Holy Bible', 'th');
INSERT INTO versions (id, code, name, language) VALUES (68, 'TUR', 'Türkçe Kutsal Kitap', 'tr');
INSERT INTO versions (id, code, name, language) VALUES (69, 'SWA', 'Swahili New Testament', 'sw');
INSERT INTO versions (id, code, name, language) VALUES (70, 'LAV', 'Latviešu Bībele', 'lv');
INSERT INTO versions (id, code, name, language) VALUES (71, 'MRI', 'Paipera Tapu (Maori)', 'mi');
INSERT INTO versions (id, code, name, language) VALUES (72, 'CHR', 'Cherokee New Testament', 'chr');
INSERT INTO versions (id, code, name, language) VALUES (73, 'PASTORAL', 'Bíblia Sagrada - Edição Pastoral (Católica)', 'pt');
