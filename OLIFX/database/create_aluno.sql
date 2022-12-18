-- Script para remover erro de Group by no SQL
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

-- Script para criar usuário "aluno" com senha "aluno"
CREATE USER IF NOT EXISTS 'aluno'@'localhost' IDENTIFIED BY 'aluno';
GRANT ALL PRIVILEGES ON olifx.* TO 'aluno'@'localhost';
