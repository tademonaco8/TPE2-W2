-- Creo la Base de datos para crear las tablas
CREATE DATABASE `Encendedores`;
-- Agrego tabla Encendedor
CREATE TABLE `Encendedores`.`Encendedor` (
    `id` INT(4) NOT NULL AUTO_INCREMENT,
    `producto` VARCHAR(40) NOT NULL,
    `tipo_FK` INT(3) NOT NULL,
    `precio` DECIMAL(10) NOT NULL,
    `descripcion` VARCHAR(200),
    `img_url` VARCHAR(140),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
-- Agrego tabla Tipo encendedores
CREATE TABLE `Encendedores`.`Tipo` (
    `id_tipo` INT(3) NOT NULL AUTO_INCREMENT,
    `descripcion_tipo` VARCHAR(40) NOT NULL,
    `tipo_gas` VARCHAR(40) NOT NULL,
    PRIMARY KEY (`id_tipo`)
) ENGINE = InnoDB;
-- agrego tabla user
CREATE TABLE `Encendedores`.`User` (
    `user` VARCHAR(40) NOT NULL,
    `password` VARCHAR(255) NOT NULL
);
-- agrego FK en tipoEncendedor
ALTER TABLE `encendedor`
ADD FOREIGN KEY (`tipo_FK`) REFERENCES `tipo`(`id_tipo`) ON DELETE RESTRICT ON UPDATE NO ACTION;
-- Inserto nuevos campos en las tablas
INSERT INTO `Tipo` (`id_tipo`, `descripcion_tipo`, `tipo_gas`)
VALUES ('1', 'Tipo Zippo', 'Bencina'),
    ('2', 'A gas', 'Gas butano'),
    ('3', 'Electrico', 'USB');
INSERT INTO `Encendedor` (
        `id`,
        `producto`,
        `tipo_fk`,
        `precio`,
        `descripcion`,
        `img_url`
    )
VALUES (
        '1',
        'Encendedor a bencina liso',
        '1',
        '1400.0',
        'Encendedor tipo Zippo.',
        'https://http2.mlstatic.com/D_NQ_NP_747761-MLA51653700771_092022-O.webp'
    ),
    (
        '2',
        'Encendedor a bencina con diseno',
        '1',
        '1900.0',
        'Encendedor tipo Zippo.',
        'https://http2.mlstatic.com/D_NQ_NP_757512-MLA46143676046_052021-O.webp'
    ),
    (
        '3',
        'Encendedor Clipper grande',
        '2',
        '290.0',
        'Encendedor Clipper grande con disenos varios.',
        'https://http2.mlstatic.com/D_NQ_NP_735640-MLA50598926605_072022-O.webp'
    ),
    (
        '4',
        'Encendedor Clipper chico',
        '2',
        '185.0',
        'Encendedor Clipper chico con diseno o liso.',
        'https://http2.mlstatic.com/D_NQ_NP_944005-MLA42802074230_072020-O.webp'
    ),
    (
        '5',
        'Encendedor electrico USB',
        '3',
        '2300.0',
        'Encendedor electrico catalitico.',
        'https://http2.mlstatic.com/D_NQ_NP_642137-MLA49939208610_052022-O.webp'
    ),
    (
        '6',
        'Encendedor catalitico',
        '2',
        '349.9',
        'Encendedor a gas catalitico.',
        'https://http2.mlstatic.com/D_NQ_NP_834396-MLA49352234577_032022-O.webp'
    );
INSERT INTO `user`(`user`, `password`, `email`)
VALUES (
        'admin',
        '$2a$12$H4VNqtG6S.3M826XBcHCeOCfkGiCqgS9z6HZSLTa3hxeR6VJvq4FO'
    )