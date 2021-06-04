create database golf;
CREATE TABLE components (
  id int(10) NOT NULL,
  name varchar(50) NOT NULL,
  description varchar(300) NOT NULL
);

CREATE TABLE `disabilities` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL
) ;


CREATE TABLE `disabilities_components` (
  `id` int(10) NOT NULL,
  `disability_id` int(10) NOT NULL,
  `component_id` int(10) NOT NULL
);

CREATE TABLE `disabilities_templates` (
  `id` int(10) NOT NULL,
  `disability_id` int(10) NOT NULL,
  `template_id` int(10) NOT NULL
) ;

CREATE TABLE `templates` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  isAdmin int(1) NOT NULL
);



/*Primary and foreing keys*/
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);
    
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `disabilities`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `disabilities_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_component` (`component_id`),
  ADD KEY `fk_disability_component` (`disability_id`);

ALTER TABLE `disabilities_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_disability` (`disability_id`),
  ADD KEY `fk_template` (`template_id`);
  
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

/*Auto increments index*/
ALTER TABLE `components`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `disabilities`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `disabilities_components`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `disabilities_templates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `templates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `disabilities_components`
  ADD CONSTRAINT `fk_component` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_disability_component` FOREIGN KEY (`disability_id`) REFERENCES `disabilities` (`id`);

ALTER TABLE `disabilities_templates`
  ADD CONSTRAINT `fk_disability` FOREIGN KEY (`disability_id`) REFERENCES `disabilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_template` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `components` (`id`, `name`, `description`) VALUES
(1, 'boton_accesible', 'Boton adecuado para personas con discapacidades de vista'),
(2, 'checkbox', 'Chechbox para personas con discapacidades visuales o fisicas'),
(3, 'saltar_main', 'boton apropiado para personas con discapacidad fisica');

INSERT into templates (`id`,`name`,`description`) values (1, 'contacto_accesible', 'Formulario adecuado para discapacidad visual, fisica y que implemta el standar Aria'), (2, 'formulario_accesible', 'Formulario adecuado para discapacidad visual, fisica y que implemta el standar Aria'), (3, 'header_accesible', 'Cabecera adecuada para personas con discapacidades de vista');

INSERT INTO `disabilities` (`id`, `name`, `description`) VALUES
(1, 'discapacidad fisica', 'Son aquellas que presentan una disminución importante en la capacidad de movimiento de una o varias partes del cuerpo'),
(2, 'discapacidad auditiva', 'Se consideran como discapacidad auditiva o las deficiencias auditivas como aquellas alteraciones cuantitativas en una correcta percepción de la audición.'),
(3, 'discapacidad visual', 'La discapacidad visual adopta la forma de ceguera y baja visión. Las personas con ceguera no reciben ninguna información visual'),
(4, 'discapacidad intelectual', 'La discapacidad intelectual es una alteración en el desarrollo del ser humano caracterizada por limitaciones significativas tanto en el funcionamiento intelectual como en las conductas adaptativas'),
(5, 'daltonismo', 'El daltonismo es una alteración de origen genético que afecta a la capacidad de distinguir los colores');

INSERT INTO disabilities_components (id,disability_id,component_id) values
(1,1,3),
(2,1,2),
(3,3,2),
(4,1,3);

INSERT INTO disabilities_templates (`id`,`disability_id`,`template_id`) values (1,3,1), (2,1,1), (3,1,2), (4,3,2), (5,3,3);


INSERT INTO users (`id`,`name`,`password`,`email`,`isAdmin`) VALUES
(null, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com',1),
(null, 'usuario', 'f8032d5cae3de20fcec887f395ec9a6a', 'usuario@gmail.com',0);
