--
-- Base de datos: `xxxx`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `dni` int(8) NOT NULL,
  `photo` varchar(60) NOT NULL,
  `logo` varchar(60) NOT NULL,
  `group_name` varchar(120) NOT NULL,
  `estado` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `per_name` varchar(60) NOT NULL,
  `description` varchar(60) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol_name` varchar(60) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permission`
--

CREATE TABLE `rol_permission` (
  `rol_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(60) DEFAULT NULL,
  `codigo_modular` varchar(7) DEFAULT NULL,
  `color` varchar(15) DEFAULT NULL,
  `colorletter` varchar(15) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `message` varchar(120) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `start_voting`
--

CREATE TABLE `start_voting` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `studentroles`
--

CREATE TABLE `studentroles` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `dni` int(8) NOT NULL,
  `password` varchar(120) NOT NULL,
  `school_id` int(11) NOT NULL,
  `votinggroup_id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `studentrol_id` int(11) DEFAULT NULL,
  `date_voting` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `school_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votinggroups`
--

CREATE TABLE `votinggroups` (
  `id` int(11) NOT NULL,
  `group_name` int(6) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_school_candidate` (`school_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol_permission`
--
ALTER TABLE `rol_permission`
  ADD KEY `fk_rol` (`rol_id`),
  ADD KEY `fk_permisos` (`permission_id`);

--
-- Indices de la tabla `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `start_voting`
--
ALTER TABLE `start_voting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_start` (`student_id`),
  ADD KEY `fk_school_start` (`school_id`);

--
-- Indices de la tabla `studentroles`
--
ALTER TABLE `studentroles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_school_student` (`school_id`),
  ADD KEY `fk_votinggroup_student` (`votinggroup_id`),
  ADD KEY `fk_candidate_student` (`candidate_id`),
  ADD KEY `fk_roles_student` (`studentrol_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rol_user` (`rol_id`),
  ADD KEY `fk_school_user` (`school_id`);

--
-- Indices de la tabla `votinggroups`
--
ALTER TABLE `votinggroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_school_votinggroup` (`school_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `start_voting`
--
ALTER TABLE `start_voting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `studentroles`
--
ALTER TABLE `studentroles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `votinggroups`
--
ALTER TABLE `votinggroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `fk_school_candidate` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rol_permission`
--
ALTER TABLE `rol_permission`
  ADD CONSTRAINT `fk_permisos` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `start_voting`
--
ALTER TABLE `start_voting`
  ADD CONSTRAINT `fk_school_start` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_student_start` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `	fk_studentrol_student` FOREIGN KEY (`studentrol_id`) REFERENCES `studentroles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_candidate_student` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_roles_student` FOREIGN KEY (`studentrol_id`) REFERENCES `studentroles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_school_student` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_votinggroup_student` FOREIGN KEY (`votinggroup_id`) REFERENCES `votinggroups` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_rol_user` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_school_user` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `votinggroups`
--
ALTER TABLE `votinggroups`
  ADD CONSTRAINT `fk_school_votinggroup` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;
COMMIT;


--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `per_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.index', 'ver dashboard', '2022-09-26 18:06:08', NULL),
(2, 'users.index', 'Ver usuarios', '2022-09-26 18:28:14', '2022-10-09 13:31:32'),
(3, 'schools.myschool', 'Mi colegio', '2022-09-26 18:28:35', '2022-10-09 13:32:24'),
(4, 'votinggroups.index', 'ver mesa sufragio', '2022-09-26 18:28:52', '2022-10-09 13:34:12'),
(5, 'students.index', 'ver estudiantes', '2022-09-26 18:29:03', '2022-10-09 13:35:09'),
(6, 'studentroles.index', 'ver roles estudiante', '2022-10-09 13:36:06', NULL),
(7, 'candidates.index', 'ver candidatos', '2022-10-09 13:36:55', NULL),
(8, 'actas.index', 'ver materiales y actas', '2022-10-09 13:38:08', NULL);

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol_name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmim', NULL, NULL),
(2, 'Administrador', NULL, NULL),
(3, 'Comite', NULL, NULL),
(4, 'Dirección', NULL, NULL);

--
-- Volcado de datos para la tabla `rol_permission`
--

INSERT INTO `rol_permission` (`rol_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 3),
(2, 4),
(2, 5),
(2, 7),
(2, 8);

--
-- Volcado de datos para la tabla `schools`
--

INSERT INTO `schools` (`id`, `name`, `photo`, `codigo_modular`, `color`, `colorletter`, `date`, `message`, `created_at`, `updated_at`) VALUES
(1, 'SchoolAdmin', NULL, '0000077', '#000000', '#ffffff', '2022-02-20 05:00:00', 'mensage', NULL, '2022-10-09 23:34:08');

--
-- Volcado de datos para la tabla `studentroles`
--

INSERT INTO `studentroles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Presidente de mesa', '2022-09-28 21:05:36', NULL),
(2, 'Secretario de mesa', '2022-09-28 21:06:04', NULL),
(3, 'Vocal de mesa', '2022-09-28 21:06:19', NULL);

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `school_id`, `rol_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'carlostucno@tucno.com', '$2y$10$7KZogyjl/UGGyxoVz/Cfw.6MxT9kYxYTH9sFoCqci4m7k4EqE9Xda', 1, 1, 1, NULL, '2022-10-15 00:31:28');

