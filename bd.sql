/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.3.29-MariaDB-0ubuntu0.20.04.1 : Database - fatecalc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fatecalc` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `fatecalc`;

/*Table structure for table `formulas` */

DROP TABLE IF EXISTS `formulas`;

CREATE TABLE `formulas` (
  `idFormula` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPagina` int(10) unsigned NOT NULL,
  `nome` varchar(100) NOT NULL,
  `varResultado` varchar(10) NOT NULL,
  `varResultadoTex` varchar(15) NOT NULL,
  `varResultadoLabel` varchar(10) NOT NULL,
  `formula` varchar(100) NOT NULL,
  `formulaTex` varchar(100) NOT NULL,
  `ordem` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`idFormula`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `formulas` */

insert  into `formulas`(`idFormula`,`idPagina`,`nome`,`varResultado`,`varResultadoTex`,`varResultadoLabel`,`formula`,`formulaTex`,`ordem`) values 
(1,1,'Lote Econômico de Compra','LEC','LEC','LEC','sqrt((2 * D * cp) / (i * v))','\\sqrt{ 2 * D * cp \\over i * v }',1),
(3,1,'Frequência de Pedidos (anual)','FEP','FEP','FEP','D / LEC','{ D \\over LEC }',2),
(4,1,'Tempo Entre Pedidos (em dias)','TEP','TEP','TEP','360 / FEP','{ 360 \\over FEP }',3),
(5,1,'Custo Total Econômico','CTE','CTE','CTE','((LEC * v * i) / 2) + ((cp * D) / LEC)','{ LEC * v * i \\over 2} + { cp * D \\over LEC }',4),
(6,2,'Lote Econômico de Fabricação','LEF','LEF','LEF','sqrt((2 * Cp * D) / (Cf * i * (1 - (u / p))))','\\sqrt{ 2 * C_p * D \\over C_f * i * \\left( 1 - \\left({ u \\over p }\\right)\\right)}',1),
(7,2,'Número de lotes a serem fabricados','N','N','N','D / LEF','{ D \\over LEF }',2),
(8,2,'Estoque médio','Emedio','E_{médio}','E. médio','(1 - (u / p)) * (LEF / 2)','\\left( 1 - \\left({ u \\over p }\\right)\\right) * { LEF \\over 2 }',3),
(9,2,'Custo do sistema','CS','CS','CS','(Cf * D) + (Cp * N) + (Cf * i * Emedio)',' C_f * D + C_p * N + C_f * i * E_{médio} ',4),
(10,3,'Preço médio unitário','PMu','PMu','PMu','SVE / SQE','{ \\sum ve \\over \\sum e }',1),
(11,3,'Estoque médio','EM','EM','EM','SQE / T','{ \\sum e \\over T }',2),
(12,3,'Custo de armazenagem unitário','CAu','CAu','CAu','(J  + CAL + SEG + PD + IMP + MOV + MO + DES) / VMEP','{ J + CAL + SEG + PD + IMP + MOV + MO + DES \\over VMEP }',3),
(13,3,'Custo de armazenagem','CA','CA','CA','EM * PMu * T * CAu',' EM * PMu * T * CAu ',4),
(14,4,'Consumo Médio Mensal','CMM','CMM','CMM','SSE / T','{ \\sum se \\over T }',1),
(15,4,'Estoque de Segurança','ES','ES','ES','CMM * (d / 30)',' CMM * { d \\over 30 }',2),
(16,4,'Ponto de Pedido','PP','PP','PP','ES + ((TR / 30) * CMM)',' ES + { TR \\over 30 } * CMM ',3),
(17,9,'Equação de 2º grau','x','x','x','-b + sqrt(b * b - (4 * a * c))) / 2 * a','{ - b +- \\sqrt{ b ^ 2 - 4 a c } \\over 2 a }',1);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `idMenu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idMenuPai` int(10) unsigned NOT NULL DEFAULT 0,
  `menu` varchar(200) NOT NULL,
  `icone` varchar(50) NOT NULL DEFAULT '',
  `idPagina` int(10) unsigned NOT NULL DEFAULT 0,
  `url` varchar(250) NOT NULL DEFAULT '',
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`idMenu`),
  KEY `idMenuPai` (`idMenuPai`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

/*Data for the table `menus` */

insert  into `menus`(`idMenu`,`idMenuPai`,`menu`,`icone`,`idPagina`,`url`,`ordem`) values 
(1,0,'Fundamentos de Logística','',0,'',0),
(2,1,'Custo de Armazenagem','',3,'',1),
(3,1,'Ponto de Pedido','',4,'',2),
(4,1,'Lote Econômico de Compra','',1,'',3),
(5,1,'Lote Econômico de Fabricação','',2,'',4),
(6,1,'Curva ABC','',5,'',5),
(7,1,'Demanda Simples','',6,'',6),
(8,1,'Demanda Ponderada','',7,'',7),
(9,1,'Reta dos Mínimos Quadrados','',8,'',8),
(16,0,'Pesquisa Operacional','',0,'',0),
(17,16,'Algoritmo de Disktra','',0,'https://graphonline.ru/p',0),
(18,16,'Fluxo Máximo','',0,'https://graphonline.ru/p',0),
(19,16,'Programação Linear','',0,'https://www.ufjf.br/epd015/files/2010/06/tutorial.pdf',0),
(20,16,'Programação Não Linear','',0,'#',0),
(21,0,'Diversos','',0,'',1),
(22,21,'Equação de 2º grau','',9,'',2),
(23,21,'Cálculos de áreas','',0,'',3),
(24,21,'Cálculos de volumes','',0,'',4),
(25,23,'Retângulo','',0,'',1),
(26,23,'Quadrado','',0,'',2),
(27,23,'Triângulo','',0,'',3),
(28,23,'Círculo','',0,'',4),
(29,23,'Losango','',0,'',5),
(30,23,'Trapézio','',0,'',6),
(31,24,'Prisma base retangular','',0,'',1),
(32,24,'Prisma base triangular','',0,'',2),
(33,24,'Volume do cilindro','',0,'',3),
(34,24,'Volume do cone','',0,'',4),
(35,24,'Pirâmide base quadrangular','',0,'',5),
(36,24,'Pirâmide base triangular','',0,'',6);

/*Table structure for table `paginas` */

DROP TABLE IF EXISTS `paginas`;

CREATE TABLE `paginas` (
  `idPagina` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `endereco` varchar(100) NOT NULL,
  `subtitulo` varchar(100) NOT NULL DEFAULT '',
  `titulo` varchar(100) NOT NULL DEFAULT '',
  `preTratamento` text NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`idPagina`),
  UNIQUE KEY `endereco` (`endereco`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `paginas` */

insert  into `paginas`(`idPagina`,`endereco`,`subtitulo`,`titulo`,`preTratamento`,`texto`) values 
(1,'lote-economico-de-compra','Fundamentos de Logística','Lote Econômico de Compra','            if (document.forms[0].elements.DPeriodo.value != document.forms[0].elements.iPeriodo.value) {\r\n                if (document.forms[0].elements.iPeriodo.value == \'M\') {\r\n                    $(\'#D\')[0].mask.unmaskedValue = ($(\'#D\')[0].mask.typedValue / 12).toString();\r\n                } else {\r\n                    $(\'#D\')[0].mask.unmaskedValue = ($(\'#D\')[0].mask.typedValue * 12).toString();\r\n                }\r\n                document.forms[0].elements.DPeriodo.value = document.forms[0].elements.iPeriodo.value;\r\n            }\r\n            if (document.forms[0].elements.iValor.value == \'P\') {\r\n                if ($(\'#i\')[0].mask.typedValue > 1) {\r\n                    $(\'#i\')[0].mask.unmaskedValue = ($(\'#i\')[0].mask.typedValue / 100).toString();\r\n                }\r\n            } else {\r\n                $(\'#i\')[0].mask.unmaskedValue = ($(\'#i\')[0].mask.typedValue / $(\'#v\')[0].mask.typedValue).toString();\r\n                document.forms[0].elements.iValor.value = \'P\';\r\n            }',''),
(2,'lote-economico-de-fabricacao','Fundamentos de Logística','Lote Econômico de Fabricação','            if (document.forms[0].elements.DPeriodo.value != document.forms[0].elements.iPeriodo.value) {\r\n                if (document.forms[0].elements.iPeriodo.value == \'M\') {\r\n                    $(\'#D\')[0].mask.unmaskedValue = ($(\'#D\')[0].mask.typedValue / 12).toString();\r\n                } else {\r\n                    $(\'#D\')[0].mask.unmaskedValue = ($(\'#D\')[0].mask.typedValue * 12).toString();\r\n                }\r\n                document.forms[0].elements.DPeriodo.value = document.forms[0].elements.iPeriodo.value;\r\n            }\r\n            if (document.forms[0].elements.uPeriodo.value != document.forms[0].elements.iPeriodo.value) {\r\n                if (document.forms[0].elements.iPeriodo.value == \'M\') {\r\n                    $(\'#u\')[0].mask.unmaskedValue = ($(\'#u\')[0].mask.typedValue / 12).toString();\r\n                } else {\r\n                    $(\'#u\')[0].mask.unmaskedValue = ($(\'#u\')[0].mask.typedValue * 12).toString();\r\n                }\r\n                document.forms[0].elements.uPeriodo.value = document.forms[0].elements.iPeriodo.value;\r\n            }\r\n            if (document.forms[0].elements.iValor.value == \'P\') {\r\n                if ($(\'#i\')[0].mask.typedValue > 1) {\r\n                    $(\'#i\')[0].mask.unmaskedValue = ($(\'#i\')[0].mask.typedValue / 100).toString();\r\n                }\r\n            } else {\r\n                $(\'#i\')[0].mask.unmaskedValue = ($(\'#i\')[0].mask.typedValue / $(\'#v\')[0].mask.typedValue).toString();\r\n                document.forms[0].elements.iValor.value = \'P\';\r\n            }',''),
(3,'custo-de-armazenagem','Fundamentos de Logística','Custo de Armazenagem','',''),
(4,'ponto-de-pedido','Fundamentos de Logística','Ponto de Pedido','<p>O <b>Ponto de Pedido ou ponto de encomenda (PP)</b> informa quando é necessário suprir determinado item de estoque, tomando como base o estoque mínimo.</p>\r\n\r\n<p>O <b>Estoque de Segurança (ES)</b> é a quantidade de material destinada a evitar ruptura de estoque, ocasionada por dilatação de tempo de ressuprimento (atrasos na entrega ou qualidade) ou aumento de demanda em relação ao previsto.</p>\r\n\r\n<p>Existem varias maneiras de calcular o ES. Uma outra forma de calcular é usando a demanda máxima menos a demanda mínima e multiplica-se o resultado pelo tempo de reposição, porém, com este cálculo, o ES é altíssimo.</p>\r\n\r\n<p>Cada empresa adota o estoque de segurança que lhe convém, algumas trabalham com estoque de segurança igual a zero. Pode-se usar, por exemplo, estoque de segurança para 15 dias ou 30 dias.</p>\r\n\r\n<p>O <b>Consumo Médio (CM)</b> é a média aritmética do consumo previsto ou realizado num\r\ndeterminado período.</p>',''),
(5,'curva-abc','Fundamentos de Logística','Curva ABC','',''),
(6,'demanda-simples','Fundamentos de Logística','Demanda Simples','',''),
(7,'demanda-ponderada','Fundamentos de Logística','Demanda Ponderada','',''),
(8,'reta-dos-minimos-quadrados','Fundamentos de Logística','Reta dos Mínimos Quadrados','',''),
(9,'equacao-de-2o-grau','','Equação de 2º grau','','A fórmula de Bhaskara é um método resolutivo para equações do segundo grau cujo nome homenageia o grande matemático indiano que a demonstrou. Essa fórmula nada mais é do que um método para encontrar as raízes reais de uma equação do segundo grau fazendo uso apenas de seus coeficientes. Vale lembrar que coeficiente é o número que multiplica\r\numa incógnita em uma equação. Em sua forma original, a fórmula de Bhaskara é dada pela\r\nexpressão:');

/*Table structure for table `variaveis` */

DROP TABLE IF EXISTS `variaveis`;

CREATE TABLE `variaveis` (
  `idVariavel` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPagina` int(10) unsigned NOT NULL,
  `variavel` varchar(10) NOT NULL,
  `variavelTex` varchar(15) NOT NULL,
  `variavelLabel` varchar(10) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `resultado` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `componente` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `monetario` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `casas` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `periodo` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `periodoPadrao` char(1) DEFAULT NULL COMMENT 'M=Mensal, A=Anual',
  `tipoValor` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `tipoValorPadrao` char(1) DEFAULT NULL COMMENT 'P=Percentual, R=Real',
  `largura` tinyint(1) unsigned NOT NULL DEFAULT 3,
  `ordem` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`idVariavel`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

/*Data for the table `variaveis` */

insert  into `variaveis`(`idVariavel`,`idPagina`,`variavel`,`variavelTex`,`variavelLabel`,`descricao`,`resultado`,`componente`,`monetario`,`casas`,`periodo`,`periodoPadrao`,`tipoValor`,`tipoValorPadrao`,`largura`,`ordem`) values 
(1,1,'D','D','D','Demanda ou consumo médio',0,0,0,2,1,'A',0,NULL,3,1),
(2,1,'cp','cp','cp','Custo de aquisição/ordem/pedido',0,0,1,2,0,NULL,0,NULL,3,2),
(3,1,'i','i','i','Taxa de juros ou custo de manutenção ou custo de armazenagem/estocagem',0,0,0,3,1,'A',1,'P',3,3),
(4,1,'v','v','v','Valor/custo unitário',0,0,1,2,0,NULL,0,NULL,3,4),
(5,1,'LEC','LEC','LEC','Lote Econômico de Compra',1,0,0,0,0,NULL,0,NULL,4,5),
(7,1,'FEP','FEP','FEP','Frequência de Pedidos (anual)',1,0,0,0,0,NULL,0,NULL,4,7),
(8,1,'TEP','TEP','TEP','Tempo Entre Pedidos (em dias)',1,0,0,0,0,NULL,0,NULL,4,8),
(9,1,'CTE','CTE','CTE','Custo Total Econômico',1,0,1,2,0,NULL,0,NULL,4,9),
(10,2,'Cp','C_p','Cp','Custo para preparar a produção para cada lote',0,0,1,2,0,NULL,0,NULL,4,1),
(11,2,'D','D','D','Demanda do item para o período considerado',0,0,0,0,1,'A',0,NULL,4,2),
(12,2,'Cf','C_f','Cf','Custo unitário de fabricação',0,0,1,2,0,NULL,0,NULL,4,3),
(13,2,'i','i','i','Taxa de juros do período',0,0,0,3,1,'A',1,'P',4,4),
(14,2,'u','u','u','Taxa de utilização por período (em dias)',0,0,0,0,1,'A',0,NULL,4,5),
(15,2,'p','p','p','Taxa de produção (por dia)',0,0,0,0,0,NULL,0,NULL,4,6),
(16,2,'LEF','LEF','LEF','Lote Econômico de Fabricação',1,0,0,0,0,NULL,0,NULL,4,7),
(17,2,'N','N','N','Número de lotes a serem fabricados',1,0,0,0,0,NULL,0,NULL,4,8),
(18,2,'Emedio','E_{médio}','E. médio','Estoque médio no período',1,0,0,0,0,NULL,0,NULL,4,9),
(19,2,'CS','CS','CS','Custo do sistema',1,0,1,2,0,NULL,0,NULL,4,10),
(20,3,'SVE','\\sum ve','Σ ve','Soma dos valores do estoque',0,0,1,2,0,NULL,0,NULL,3,1),
(21,3,'SQE','\\sum e','Σ e','Soma das quantidades do estoque',0,0,0,0,0,NULL,0,NULL,3,2),
(22,3,'T','T','T','Quantidade de períodos (Tempo)',0,0,0,0,0,NULL,0,NULL,3,3),
(23,3,'J','J','J','Juros',0,0,1,2,0,NULL,0,NULL,3,5),
(24,3,'CAL','CAL','CAL','Custo de aluguel',0,0,1,2,0,NULL,0,NULL,3,6),
(25,3,'SEG','SEG','SEG','Despesas com seguros',0,0,1,2,0,NULL,0,NULL,3,7),
(26,3,'PD','PD','PD','Perdas',0,0,1,2,0,NULL,0,NULL,3,8),
(27,3,'IMP','IMP','IMP','Despesas com impostos',0,0,1,2,0,NULL,0,NULL,3,9),
(28,3,'MOV','MOV','MOV','Custo com movimentação',0,0,1,2,0,NULL,0,NULL,3,10),
(29,3,'MO','MO','MO','Custo com mão de obra',0,0,1,2,0,NULL,0,NULL,3,11),
(30,3,'DES','DES','DES','Despesas em geral',0,0,1,2,0,NULL,0,NULL,3,12),
(31,3,'PMu','PMu','PMu','Preço Médio unitário',1,0,1,3,0,NULL,0,NULL,4,13),
(32,3,'EM','EM','EM','Estoque Médio',1,0,0,0,0,NULL,0,NULL,4,14),
(33,3,'CAu','CAu','CAu','Custo de Armazenagem unitário',1,0,1,4,0,NULL,0,NULL,4,15),
(34,3,'CA','CA','CA','Custo de Armazenagem',1,0,1,2,0,NULL,0,NULL,4,16),
(35,3,'VMEP','VMEP','VMEP','Valor Médio do Estoque no Período',0,0,1,2,0,NULL,0,NULL,3,4),
(36,4,'SSE','\\sum se','Σ se','Soma das saídas do estoque',0,0,0,0,0,NULL,0,NULL,3,1),
(37,4,'T','T','T','Quantidade de períodos (Tempo)',0,0,0,0,0,NULL,0,NULL,3,2),
(38,4,'d','d','d','Dias de estoque de segurança',0,0,0,0,0,NULL,0,NULL,3,3),
(39,4,'TR','TR','TR','Tempo de Reposição / prazo de entrega (em dias)',0,0,0,0,0,NULL,0,NULL,3,4),
(40,4,'CMM','CMM','CMM','Consumo Médio Mensal',1,0,0,0,0,NULL,0,NULL,4,5),
(41,4,'ES','ES','ES','Estoque de Segurança',1,0,0,0,0,NULL,0,NULL,4,6),
(42,4,'PP','PP','PP','Ponto de Pedido',1,0,0,0,0,NULL,0,NULL,4,7),
(43,9,'a','a','a','',0,0,0,1,0,NULL,0,NULL,2,1),
(44,9,'b','b','b','',0,0,0,1,0,NULL,0,NULL,2,2),
(45,9,'c','c','c','',0,0,0,1,0,NULL,0,NULL,2,3),
(46,9,'x1','x1','x1','',1,0,0,1,0,NULL,0,NULL,4,4),
(47,9,'x2','x2','x2','',1,0,0,1,0,NULL,0,NULL,4,5);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
