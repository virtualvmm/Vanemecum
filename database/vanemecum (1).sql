-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2025 a las 12:01:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vanemecum`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alarmas`
--

CREATE TABLE `alarmas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patogeno_id` bigint(20) UNSIGNED NOT NULL,
  `diagnostico_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nivel_prioridad` enum('Baja','Media','Alta','Crítica') NOT NULL DEFAULT 'Media' COMMENT 'Nivel de riesgo de la alarma.',
  `mensaje_alerta` varchar(500) NOT NULL COMMENT 'Descripción de la condición que causó la alarma.',
  `fecha_hora_activacion` datetime NOT NULL COMMENT 'Fecha y hora exacta de la activación.',
  `estado` enum('Activa','Resuelta','Ignorada','Pendiente') NOT NULL DEFAULT 'Activa' COMMENT 'Estado actual de la alarma.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `organizacion` varchar(255) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnosticos`
--

CREATE TABLE `diagnosticos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `resultado_final` enum('Positivo','Negativo','Inconcluso') NOT NULL DEFAULT 'Inconcluso' COMMENT 'Resultado del análisis o diagnóstico.',
  `observaciones` text DEFAULT NULL COMMENT 'Notas o detalles sobre el diagnóstico.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fuentes_informacion`
--

CREATE TABLE `fuentes_informacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fuentes_informacion`
--

INSERT INTO `fuentes_informacion` (`id`, `nombre`, `url`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'CDC', 'https://www.cdc.gov/', 'Centros para el Control y la Prevención de Enfermedades.', NULL, NULL),
(2, 'OMS', 'https://www.who.int/', 'Organización Mundial de la Salud.', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_10_28_000000_create_tablas_auxiliares_table', 1),
(6, '2025_10_28_100000_create_patogenos_table', 1),
(7, '2025_10_28_111000_create_diagnosticos_table', 1),
(8, '2025_10_28_111200_create_sintomas_table', 1),
(9, '2025_10_28_111429_create_alarmas_table', 1),
(10, '2025_10_28_112000_create_tratamientos_table', 1),
(11, '2025_10_28_113000_create_roles_table', 1),
(12, '2025_10_28_114000_create_patogeno_sintoma_table', 1),
(13, '2025_10_28_115000_create_patogeno_tratamiento_table', 1),
(14, '2025_10_28_120000_create_role_user_table', 1),
(15, '2025_10_28_121000_create_patogeno_user_table', 1),
(16, '2025_10_28_122000_create_contactos_table', 1),
(17, '2025_10_28_123000_create_noticias_table', 1),
(18, '2025_11_05_000001_add_tipo_id_to_tratamientos_table', 2),
(19, '2025_11_05_000002_add_user_extra_fields', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL COMMENT 'Título de la noticia.',
  `cuerpo` text NOT NULL COMMENT 'Contenido completo de la noticia.',
  `categoria` enum('Alerta','Noticia','Publicación','Evento') NOT NULL DEFAULT 'Noticia' COMMENT 'Clasificación temática.',
  `estado` enum('Borrador','Publicado','Archivado') NOT NULL DEFAULT 'Borrador' COMMENT 'Estado de visibilidad.',
  `fecha_publicacion` datetime DEFAULT NULL COMMENT 'Fecha y hora de publicación.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patogenos`
--

CREATE TABLE `patogenos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `tipo_patogeno_id` bigint(20) UNSIGNED NOT NULL,
  `fuente_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patogenos`
--

INSERT INTO `patogenos` (`id`, `nombre`, `descripcion`, `image_url`, `is_active`, `tipo_patogeno_id`, `fuente_id`, `created_at`, `updated_at`) VALUES
(1, 'Cryptococcus Mabelburgh Strain f27', 'Descubierto en 1970. Accusantium non voluptas ut aut porro. Veritatis velit nihil fugiat vel. Blanditiis dolores est ut distinctio saepe sint. Requiere contención Nivel 2.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(2, 'Streptococcus Alfredafort Strain s50', 'Descubierto en 2011. Numquam quis accusamus quo tempora dolores soluta. Sint sed accusamus nam rerum. Et nesciunt est sed repellat. Fugiat magni in cumque ad voluptatibus. Requiere contención Nivel 2.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(3, 'Virus de la Port Easterstad Strain c8', 'Descubierto en 2017. Doloremque dolore possimus voluptates minus. Est non accusantium ut cum. Voluptate ratione dicta deleniti eaque. Veritatis libero rerum eius ex odio id doloribus. Qui deleniti explicabo molestias nulla officia. Sit eius impedit animi occaecati nulla et. Requiere contención Nivel 2.', NULL, 1, 1, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(4, 'Agente Patógeno Marquisemouth Strain m95', 'Descubierto en 2007. Nihil odio corrupti ut maiores libero beatae ut. Rerum doloremque sint distinctio in minus velit amet. Nesciunt nostrum quibusdam ea exercitationem molestias enim. Requiere contención Nivel 2.', NULL, 1, 4, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(5, 'Aspergillus Oberbrunnerport Strain c21', 'Descubierto en 1989. Soluta nostrum blanditiis asperiores temporibus praesentium velit qui. Ut est eum adipisci recusandae magni non similique. Qui dolore aut enim magnam. Atque ut vero eos ea aut omnis quia. Qui iusto quos suscipit optio. Requiere contención Nivel 2.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(6, 'E. coli Flatleyberg Strain b57', 'Descubierto en 1991. Iste in et officiis quia reiciendis adipisci molestiae. Eos dolor id facilis accusantium repellendus vel. Qui et velit laboriosam praesentium. Sed ratione ut temporibus. Requiere contención Nivel 3.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(7, 'E. coli Jastchester Strain m15', 'Descubierto en 1981. Sequi qui nam perspiciatis non laborum dolores odit. Sit exercitationem sit et quasi. Ullam porro aut asperiores fugiat aut iste. Requiere contención Nivel 3.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(8, 'Candida South Santaton Strain q88', 'Descubierto en 1998. Magnam dolorem recusandae pariatur odit dolor nobis. Dolor omnis et magni itaque nobis non. Aut sed rerum voluptas. Requiere contención Nivel 1.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(9, 'Salmonella Courtneystad Strain n95', 'Descubierto en 1997. Quo dolores velit nihil aspernatur voluptates. Dolores inventore dignissimos fugiat occaecati. Voluptatem rerum odio consequuntur recusandae in qui. Requiere contención Nivel 4.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(10, 'Agente Patógeno Lorenzaborough Strain j55', 'Descubierto en 2010. Doloremque doloribus voluptas ipsam ab in possimus consequatur. Impedit et nam veritatis excepturi fuga. Provident distinctio dolorum ut velit sapiente. Omnis ea in soluta dolor aut. Requiere contención Nivel 1.', NULL, 1, 4, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(11, 'Salmonella North Demarcotown Strain l25', 'Descubierto en 2024. Incidunt omnis numquam consectetur itaque velit cupiditate voluptatem. Occaecati maxime officia quibusdam quisquam architecto facilis laborum. Asperiores quos ipsum et et consectetur voluptatem assumenda reiciendis. Corrupti repudiandae fugit provident officiis saepe sint. Accusamus error sunt aut tenetur. Requiere contención Nivel 3.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(12, 'Cryptococcus West Lydia Strain w67', 'Descubierto en 1981. Rerum sint magni est fugiat vero qui quidem. Et molestiae sequi natus perferendis. Voluptatum tenetur reiciendis vel dolores omnis animi. Requiere contención Nivel 4.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(13, 'Agente Patógeno Tryciaton Strain m48', 'Descubierto en 1977. Distinctio adipisci eaque esse rerum. Repudiandae in officia suscipit inventore rem nulla. Perspiciatis quas quas officiis ratione hic exercitationem. Requiere contención Nivel 3.', NULL, 1, 4, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(14, 'Cryptococcus Lake Litzybury Strain w31', 'Descubierto en 1978. At alias est eligendi et dolore sint. Neque accusamus quia eum. Dolor molestiae omnis est architecto. Corporis provident suscipit saepe vero delectus veritatis doloremque. Corrupti voluptatem et tempora. Requiere contención Nivel 4.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(15, 'Salmonella New Ahmed Strain p21', 'Descubierto en 2011. Deserunt libero officia facere quibusdam. Molestiae error amet est rem. Sit aut omnis aliquam dolore dolor placeat officiis. Assumenda quo maiores impedit numquam hic hic doloremque deserunt. Requiere contención Nivel 3.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(16, 'Adenovirus Yvonnemouth Strain a82', 'Descubierto en 1999. Laborum et eius voluptatem iste. Amet consequatur sit repellat non modi illum. Debitis voluptates non voluptatibus quos. Aliquid aut optio tempore aperiam id magnam tempora iste. Corrupti qui reiciendis qui nemo. Requiere contención Nivel 2.', NULL, 1, 1, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(17, 'Aspergillus Schusterville Strain f41', 'Descubierto en 1990. Quia vel doloribus sequi quod aperiam. Debitis illo unde ut necessitatibus dolorem et sit. Adipisci commodi ut et assumenda eaque tempore est repudiandae. Non voluptas hic perferendis fugit nobis nam iure. Ratione cumque quisquam id non maiores. Optio nesciunt repudiandae nulla asperiores ad. Requiere contención Nivel 3.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(18, 'Virus de la Raeganmouth Strain j2', 'Descubierto en 1992. Accusamus et quidem qui commodi. Atque nemo accusamus sint expedita. Placeat quis tempora consequatur. Delectus molestiae iure laudantium non deserunt sit possimus quo. Requiere contención Nivel 1.', NULL, 1, 1, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(19, 'Orthomyxovirus West Keagan Strain f19', 'Descubierto en 1980. Eaque hic et magnam sed qui officiis. Vero esse commodi quam tempora illo. Aperiam et molestiae nisi voluptatem repellendus. Recusandae quas cumque sit sequi voluptatem inventore illum. Requiere contención Nivel 1.', NULL, 1, 1, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(20, 'Aspergillus New Chloe Strain a52', 'Descubierto en 2003. Et dolores maiores hic voluptatum possimus. Qui ducimus architecto et ut et totam in. Commodi unde labore aliquam amet odio. Aut nobis vitae natus at nostrum sed. Ab delectus porro dolor ad eaque est distinctio. Requiere contención Nivel 4.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(21, 'Salmonella New Amiyaton Strain h57', 'Descubierto en 2015. Ad atque soluta explicabo aut illo et quo. Quia ut laboriosam placeat et qui consequatur. Blanditiis et ut et. Sapiente et id illo corporis rerum. Mollitia dolores et eos voluptatem rerum eaque rem. Laudantium libero eveniet blanditiis odio ipsam quibusdam. Requiere contención Nivel 1.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(22, 'Orthomyxovirus Lake Carmenmouth Strain u42', 'Descubierto en 2009. Ducimus et id temporibus quae. Laudantium ratione est quia suscipit qui odit. Qui modi aut nihil velit occaecati. Accusamus illum pariatur sit aliquid rerum ea. Totam impedit voluptatem natus iusto. Requiere contención Nivel 1.', NULL, 1, 1, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(23, 'Rinovirus East Mabelle Strain w69', 'Descubierto en 2011. Unde possimus nihil libero cupiditate est odit occaecati. Qui autem quos consequuntur voluptatem non et sed. Quia quisquam provident recusandae magnam natus est. Veniam eum sit ex omnis explicabo. Requiere contención Nivel 3.', NULL, 1, 1, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(24, 'Aspergillus New Freddymouth Strain t85', 'Descubierto en 2019. Sed praesentium dolores qui enim. At perferendis sint dolores voluptatem nobis ut. Commodi sunt ea sint molestias pariatur neque. Id et amet mollitia accusantium rem nihil. Nam tenetur dolorem architecto odit quia. In excepturi enim doloremque beatae non quam facilis iste. Requiere contención Nivel 3.', NULL, 0, 3, NULL, '2025-10-28 13:22:08', '2025-11-11 09:31:05'),
(25, 'Microorganismo Runolfssontown Strain g90', 'Descubierto en 2004. In sit est libero et natus. Rerum atque non libero dolor commodi est eos. Reiciendis officiis ab veniam autem eos sint sed. Officia sint rerum quo iste voluptatem quibusdam eveniet. Nemo id impedit facere quae. Est perspiciatis cumque facilis aut vel. Requiere contención Nivel 3.', NULL, 1, 4, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(26, 'Candida Lueilwitzfurt Strain z33', 'Descubierto en 1993. Omnis non architecto facere. Voluptatem dolores dolore saepe distinctio eum. Possimus nesciunt eligendi non alias ut. Requiere contención Nivel 1.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(27, 'Streptococcus Kaitlinland Strain t99', 'Descubierto en 2018. Ratione omnis officiis nulla a nihil et a voluptas. Corporis fugiat quod quas aut blanditiis quia. Enim nihil sapiente expedita eius aut temporibus tempora. Praesentium quia amet asperiores non. Error voluptatem est commodi neque cumque repudiandae qui. Quia enim et nostrum in reprehenderit molestiae velit. Requiere contención Nivel 3.', NULL, 1, 2, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(28, 'Cryptococcus Vestaside Strain o25', 'Descubierto en 1979. Quibusdam perspiciatis explicabo corporis mollitia totam molestiae laudantium. Voluptatem perspiciatis optio eaque dignissimos temporibus. Occaecati qui perferendis culpa harum. Sunt harum saepe recusandae deleniti et esse quis. Voluptatum debitis eligendi aliquam nihil fugit et. Requiere contención Nivel 1.', NULL, 1, 3, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(29, 'Rinovirus New Alvah Strain n57', 'Descubierto en 2005. Dolorem ducimus ea facere ipsum sed et. Ut et voluptas vero rerum odit nulla dignissimos. Nostrum id quam quisquam et corrupti nemo qui magni. Totam quia totam earum in nesciunt numquam. Officiis ducimus quia quibusdam molestiae assumenda vero. Quos ut sequi aspernatur numquam ut mollitia cum ducimus. Requiere contención Nivel 2.', NULL, 1, 1, NULL, '2025-10-28 13:22:08', '2025-10-28 13:22:08'),
(30, 'Agente Patógeno Lake Natland Strain d12', 'Descubierto en 2008. Labore praesentium quo molestiae sed et. Sint exercitationem consequatur nesciunt. Ut ipsa magnam voluptas doloribus inventore. Est magni porro dolorum vitae fugiat accusamus qui. Quas quia dolorum a et et est. Deserunt sunt debitis quaerat quia ducimus voluptatem. Requiere contención Nivel 2.', NULL, 1, 4, 2, '2025-10-28 13:22:08', '2025-11-11 09:28:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patogeno_sintoma`
--

CREATE TABLE `patogeno_sintoma` (
  `patogeno_id` bigint(20) UNSIGNED NOT NULL,
  `sintoma_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patogeno_sintoma`
--

INSERT INTO `patogeno_sintoma` (`patogeno_id`, `sintoma_id`) VALUES
(1, 4),
(1, 6),
(1, 16),
(1, 24),
(1, 25),
(2, 1),
(2, 2),
(2, 5),
(2, 20),
(2, 25),
(3, 5),
(3, 9),
(3, 10),
(3, 13),
(3, 15),
(4, 5),
(4, 6),
(4, 16),
(4, 17),
(4, 20),
(5, 9),
(5, 12),
(5, 24),
(5, 25),
(6, 3),
(6, 5),
(6, 6),
(6, 14),
(6, 18),
(6, 19),
(6, 21),
(6, 23),
(7, 10),
(7, 11),
(7, 14),
(7, 23),
(8, 4),
(8, 6),
(8, 11),
(8, 12),
(8, 14),
(8, 16),
(8, 20),
(9, 1),
(9, 2),
(9, 4),
(9, 11),
(9, 13),
(9, 21),
(10, 4),
(10, 5),
(10, 10),
(10, 15),
(11, 1),
(11, 2),
(11, 5),
(11, 6),
(11, 7),
(11, 9),
(11, 10),
(11, 24),
(12, 2),
(12, 3),
(12, 16),
(13, 2),
(13, 8),
(13, 12),
(13, 19),
(13, 20),
(13, 24),
(13, 25),
(14, 1),
(14, 3),
(14, 10),
(14, 11),
(14, 20),
(14, 21),
(14, 24),
(14, 25),
(15, 5),
(15, 6),
(15, 9),
(15, 19),
(15, 22),
(16, 9),
(16, 10),
(16, 11),
(16, 17),
(16, 18),
(16, 19),
(17, 2),
(17, 3),
(17, 8),
(17, 10),
(17, 12),
(17, 19),
(17, 25),
(18, 1),
(18, 6),
(18, 17),
(18, 18),
(18, 20),
(18, 21),
(19, 4),
(19, 11),
(19, 18),
(19, 20),
(19, 25),
(20, 1),
(20, 15),
(20, 18),
(20, 21),
(20, 24),
(21, 1),
(21, 3),
(21, 10),
(21, 12),
(21, 14),
(22, 8),
(22, 15),
(22, 19),
(22, 22),
(23, 6),
(23, 8),
(23, 9),
(23, 11),
(23, 12),
(23, 14),
(23, 17),
(23, 18),
(24, 1),
(24, 13),
(24, 17),
(24, 20),
(24, 21),
(24, 22),
(24, 25),
(25, 4),
(25, 7),
(25, 9),
(25, 13),
(25, 18),
(25, 19),
(25, 23),
(26, 1),
(26, 7),
(26, 15),
(26, 21),
(26, 23),
(27, 3),
(27, 11),
(27, 14),
(27, 20),
(27, 24),
(28, 1),
(28, 2),
(28, 9),
(28, 12),
(28, 14),
(29, 3),
(29, 7),
(29, 8),
(29, 10),
(29, 11),
(29, 13),
(29, 17),
(29, 25),
(30, 6),
(30, 17),
(30, 18),
(30, 19),
(30, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patogeno_tratamiento`
--

CREATE TABLE `patogeno_tratamiento` (
  `patogeno_id` bigint(20) UNSIGNED NOT NULL,
  `tratamiento_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patogeno_tratamiento`
--

INSERT INTO `patogeno_tratamiento` (`patogeno_id`, `tratamiento_id`) VALUES
(1, 21),
(1, 32),
(2, 10),
(2, 11),
(2, 41),
(2, 43),
(3, 2),
(3, 4),
(3, 33),
(3, 38),
(4, 13),
(4, 16),
(4, 17),
(4, 38),
(5, 22),
(5, 37),
(6, 29),
(6, 30),
(6, 37),
(7, 16),
(7, 43),
(7, 50),
(8, 43),
(8, 45),
(8, 50),
(9, 28),
(9, 34),
(9, 37),
(9, 43),
(9, 49),
(10, 18),
(10, 35),
(11, 21),
(11, 44),
(11, 47),
(12, 1),
(12, 4),
(12, 27),
(12, 39),
(12, 45),
(13, 20),
(13, 23),
(13, 31),
(13, 35),
(13, 44),
(14, 4),
(14, 47),
(15, 6),
(15, 14),
(15, 20),
(15, 30),
(16, 8),
(16, 16),
(16, 24),
(16, 36),
(17, 13),
(17, 16),
(17, 22),
(17, 29),
(18, 14),
(18, 17),
(19, 23),
(19, 48),
(20, 35),
(20, 44),
(20, 48),
(21, 6),
(21, 30),
(22, 2),
(22, 10),
(22, 27),
(22, 41),
(23, 4),
(23, 50),
(24, 12),
(24, 17),
(24, 30),
(24, 32),
(25, 4),
(25, 28),
(26, 11),
(26, 19),
(26, 23),
(26, 26),
(26, 42),
(27, 10),
(27, 31),
(27, 35),
(27, 39),
(27, 49),
(28, 3),
(28, 14),
(28, 28),
(28, 39),
(29, 2),
(29, 11),
(29, 39),
(30, 3),
(30, 41),
(30, 43),
(30, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patogeno_user`
--

CREATE TABLE `patogeno_user` (
  `patogeno_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre del rol, ej: Admin, Usuario, Médico.',
  `descripcion` varchar(255) DEFAULT NULL COMMENT 'Descripción detallada del rol.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Control total sobre el sistema y el contenido.', NULL, NULL),
(2, 'Editor', 'Puede crear y modificar contenido (Patógenos, Tratamientos, Noticias).', NULL, NULL),
(3, 'Lector', 'Solo puede ver el contenido del Vademécum.', NULL, NULL),
(4, 'Admin', 'Administrador del sistema', '2025-11-05 12:39:06', '2025-11-05 12:39:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintomas`
--

CREATE TABLE `sintomas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `gravedad` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Nivel de gravedad del síntoma (1=Leve, 5=Crítico)',
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sintomas`
--

INSERT INTO `sintomas` (`id`, `nombre`, `gravedad`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'asperiores culpa (agudo)', 3, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Recusandae dolorem recusandae consequatur quidem voluptatem repudiandae architecto ipsa.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(2, 'at sit', 4, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Deleniti corrupti ratione rerum soluta aut id sit eius nesciunt.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(3, 'doloremque mollitia (generalizado)', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Assumenda rerum non et culpa molestiae rem ratione.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(4, 'tempore animi (recurrente)', 2, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. In nihil deleniti dolorem ut esse nam id recusandae.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(5, 'est unde (localizado)', 4, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. In accusamus quia magnam corporis facere nulla eveniet eum quaerat qui sunt qui.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(6, 'perspiciatis odit (agudo)', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Quisquam odio dolor qui ut cupiditate eum earum hic vel doloremque possimus earum.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(7, 'quae iure (persistente)', 3, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Dolor numquam in praesentium itaque voluptas quia esse voluptate error.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(8, 'aliquid quisquam', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Quis sapiente rerum recusandae ea aut earum est fugit aspernatur accusantium.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(9, 'voluptatem quia (localizado)', 3, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Autem eum nesciunt provident sapiente eveniet fugit vel qui mollitia numquam.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(10, 'exercitationem molestias', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Consequatur dolor esse sequi molestias et nihil ipsa.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(11, 'soluta asperiores (localizado)', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Rerum vitae quia ut neque qui quis ut architecto reprehenderit autem consequatur expedita.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(12, 'dolorum quam', 4, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Assumenda numquam et perspiciatis tempora sit porro dolores qui dolore.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(13, 'eaque et', 4, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Soluta aspernatur ut adipisci eligendi voluptatem ratione aut.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(14, 'optio quam (localizado)', 3, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Repellat non qui et ipsum similique inventore magni.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(15, 'sint quidem (localizado)', 5, 'Síntoma de gravedad crítica. Requiere atención médica inmediata y monitorización. Cum consequuntur nihil doloribus quod quo enim quia tenetur.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(16, 'modi vero (recurrente)', 4, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Nobis sed ea quo animi aperiam harum.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(17, 'sed consectetur (persistente)', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Adipisci ipsam eligendi minus autem ea vero et mollitia deserunt corporis autem atque.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(18, 'cum beatae', 3, 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico. Quibusdam nesciunt accusantium tenetur nostrum corporis consequatur velit atque ea et corporis libero.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(19, 'soluta tenetur (generalizado)', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Dolor dolorum molestias harum totam est consequuntur architecto tempore occaecati necessitatibus voluptas molestiae est.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(20, 'qui consequatur', 5, 'Síntoma de gravedad crítica. Requiere atención médica inmediata y monitorización. Minima molestias voluptas blanditiis eum rerum quod tempore provident aliquam atque beatae ea.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(21, 'amet dolorum', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Provident et ad quaerat repellat est eum distinctio sed mollitia unde quam voluptas delectus.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(22, 'eligendi sit', 5, 'Síntoma de gravedad crítica. Requiere atención médica inmediata y monitorización. Consequuntur sit id minus consequuntur modi impedit.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(23, 'minus voluptatem (recurrente)', 2, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Aliquam qui illo officia numquam voluptas quas laboriosam eum.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(24, 'tempore dignissimos', 2, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Deleniti perferendis molestiae et velit aliquid provident.', '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(25, 'dignissimos ut', 1, 'Síntoma leve. Suele remitir con descanso y cuidados básicos. Dolorem consequatur maxime iure voluptas consequatur libero.', '2025-10-28 13:22:07', '2025-10-28 13:22:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_patogenos`
--

CREATE TABLE `tipo_patogenos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_patogenos`
--

INSERT INTO `tipo_patogenos` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Virus', 'Agente infeccioso acelular que se replica solo dentro de células vivas.', NULL, NULL),
(2, 'Bacterias', 'Organismos unicelulares procariotas.', NULL, NULL),
(3, 'Hongos', 'Organismos eucariotas que incluyen levaduras, mohos y setas.', NULL, NULL),
(4, 'Parásitos', 'Organismos que viven sobre o dentro de otro organismo y se benefician de él.', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_tratamientos`
--

CREATE TABLE `tipo_tratamientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_tratamientos`
--

INSERT INTO `tipo_tratamientos` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Antiviral', 'Medicamentos que tratan infecciones virales.', NULL, NULL),
(2, 'Antibiótico', 'Medicamentos que combaten infecciones bacterianas.', NULL, NULL),
(3, 'Antifúngico', 'Medicamentos que tratan infecciones causadas por hongos.', NULL, NULL),
(4, 'Soporte', 'Tratamientos dirigidos a aliviar síntomas.', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `descripcion` text NOT NULL,
  `duracion_dias` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Duración estimada del tratamiento en días',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`id`, `nombre`, `tipo_id`, `descripcion`, `duracion_dias`, `created_at`, `updated_at`) VALUES
(1, 'Cirugía Menor enim (622)', NULL, 'Accusamus beatae omnis similique non est corporis. Sed facere dicta ipsum quas ab esse.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(2, 'Cirugía Menor numquam (449)', NULL, 'Itaque ratione nemo illum vitae id quaerat. Omnis possimus aut incidunt explicabo.', 58, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(3, 'Terapia Física quaerat (409)', NULL, 'Dolorem dolor atque ut qui laborum ipsam sed. Et tenetur iusto corrupti itaque rerum reiciendis velit. Et culpa voluptas est tempora quis nihil molestiae.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(4, 'Antibiótico sunt (730)', NULL, 'Itaque libero consequatur eveniet accusamus. Ut rem sint sed quisquam mollitia corporis. Doloremque cumque repellat voluptatem tempora quia officiis.', 13, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(5, 'Cirugía Menor odio (579)', NULL, 'Pariatur nihil molestiae corrupti voluptates sint sed adipisci est. Amet facere facilis id quae et et. Nihil ut ratione id.', 32, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(6, 'Cirugía Menor et (223)', NULL, 'Est vero expedita doloribus voluptas aut officia. Accusantium natus quibusdam voluptate quas nesciunt. Sed doloribus rerum et rerum.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(7, 'Vacuna neque (268)', NULL, 'Fugiat alias facere qui aut. Aspernatur aut inventore velit dignissimos excepturi. Earum iste sunt soluta quam.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(8, 'Terapia Física dolorem (215)', NULL, 'Repellendus veritatis dolor odit quibusdam et odio. Architecto rerum voluptatum sequi esse soluta.', 66, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(9, 'Antiviral unde (136)', NULL, 'Iusto odit est tenetur alias. Placeat voluptatem qui vero dolores molestiae.', 19, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(10, 'Antibiótico voluptate (190)', NULL, 'Quibusdam ea perspiciatis et. Accusamus beatae odit neque ea molestias.', 77, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(11, 'Vacuna praesentium (395)', NULL, 'Harum totam voluptatem dolor ut debitis delectus accusantium. Et rerum rerum mollitia dicta tempore facilis. Vel placeat inventore similique.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(12, 'Antiviral quis (777)', NULL, 'Occaecati voluptas doloremque corporis laboriosam adipisci et rerum. Quae asperiores ea vitae distinctio est ut.', 10, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(13, 'Antiviral ad (963)', NULL, 'Doloremque facere error repellendus quos voluptas excepturi quasi. Excepturi aut vero ut quis voluptates eos nihil.', 45, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(14, 'Vacuna eum (204)', NULL, 'Ea id provident distinctio odit nemo quod possimus. Natus dolorum nobis enim animi temporibus voluptate. Voluptas eligendi animi ducimus assumenda consectetur incidunt.', 30, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(15, 'Terapia Física vel (110)', NULL, 'Rem accusamus debitis tenetur eaque. Distinctio est iure voluptas dolore adipisci ut laboriosam.', 36, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(16, 'Antiviral earum (822)', NULL, 'Dolorem sit dolorum aliquam magnam. Pariatur voluptatem mollitia sit nisi recusandae impedit. Minima eos nam omnis soluta ut est temporibus.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(17, 'Terapia Física quo (641)', NULL, 'Corrupti incidunt ab est et aliquid autem. Tempora minima asperiores ipsa quos. Quae rerum exercitationem et sit ratione rerum.', 89, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(18, 'Analgésico velit (842)', NULL, 'Officiis deserunt et non inventore. Distinctio voluptatem est ut architecto. Consequatur ut quibusdam eaque quo.', 53, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(19, 'Vacuna ut (764)', NULL, 'Et iste sed ratione ipsa laboriosam. Impedit iure quis est aliquam vel repudiandae.', 53, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(20, 'Vacuna at (532)', NULL, 'Et aspernatur quidem labore id quo labore natus veniam. Doloremque ut cumque corrupti amet. Nam odit aut cum debitis.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(21, 'Vacuna expedita (482)', NULL, 'Quam consectetur ut animi. Reprehenderit laboriosam autem ut ad perferendis quia. Et vitae in aspernatur blanditiis.', 39, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(22, 'Antibiótico modi (488)', NULL, 'Omnis fuga voluptatibus blanditiis velit. Et fuga non voluptas dignissimos delectus voluptas.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(23, 'Analgésico accusantium (810)', NULL, 'Aperiam aliquid nostrum autem ea debitis atque. Culpa eos ipsam ea incidunt hic....', 44, '2025-10-28 13:22:07', '2025-11-11 09:56:01'),
(24, 'Antiviral sapiente (761)', NULL, 'Dolor voluptas ad animi ut. Hic dolorem ut asperiores tenetur quos omnis. Fugiat unde eveniet sequi possimus et sed in quia.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(25, 'Terapia Física quia (596)', NULL, 'Doloremque velit vitae amet fugiat corporis eos. Rem illum fuga ducimus. Ea illum quaerat ad eligendi delectus fuga nihil.', 87, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(26, 'Vacuna officia (351)', NULL, 'Qui ab voluptatem magni voluptatem et sunt illum. Distinctio sint ut hic ipsa aut enim.', 79, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(27, 'Analgésico aliquam (798)', NULL, 'Eos id dignissimos quia fuga. Nisi dolorem maxime incidunt.', 67, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(28, 'Vacuna repudiandae (843)', NULL, 'Nemo voluptates ipsa iure. Dolor corporis expedita sed quae.', 7, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(29, 'Antiviral corrupti (189)', NULL, 'Quasi nesciunt sequi sapiente recusandae. Commodi possimus quia reprehenderit rerum in et. Cum dolorem consequatur vel sapiente temporibus accusantium.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(30, 'Antibiótico ea (744)', NULL, 'Quia natus iste sit sequi aperiam. Est eligendi aut qui minima. Dolor mollitia adipisci assumenda.', 30, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(31, 'Antiviral porro (541)', NULL, 'Ut a maiores consequatur nobis. Qui dolores omnis aut eum et. Velit qui et aperiam.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(32, 'Antibiótico rerum (994)', NULL, 'Maxime laudantium in vero ut porro. Eum consequatur maiores ducimus aut quidem.', 73, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(33, 'Cirugía Menor illum (489)', NULL, 'Qui repellat at tempore nam praesentium. Consequatur soluta quidem vel. Aperiam rerum ad molestias ea.', 19, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(34, 'Terapia Física voluptas (148)', NULL, 'Voluptas laboriosam at assumenda tempore. Quia aperiam asperiores qui vel nihil iure.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(35, 'Antiviral qui (471)', NULL, 'Quia at eaque velit vel sit voluptas vel perferendis. Saepe aut ut minus dolorem eius quia non.', 25, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(36, 'Antibiótico recusandae (531)', NULL, 'Doloribus quo ea sed delectus ea praesentium amet cumque. Id vero dolores quia ad consequuntur ea quae. Non sed odit doloremque aut totam ut minus rerum.', 38, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(37, 'Analgésico minima (597)', NULL, 'Quas omnis dolorem non fuga sunt. Et nostrum quas quia ut nesciunt.', 21, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(38, 'Vacuna minus (499)', NULL, 'Accusamus laboriosam occaecati et illum voluptatibus accusantium velit distinctio. Laudantium assumenda rerum saepe molestiae.', 76, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(39, 'Cirugía Menor facere (389)', NULL, 'Fugit deleniti aperiam voluptas ullam. Velit enim consectetur quas mollitia. Autem totam aut culpa ipsam ad.', 41, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(40, 'Antiviral nihil (687)', NULL, 'Est molestiae et et molestias autem quia natus. Nostrum alias voluptatum neque ea ut.', 86, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(41, 'Antibiótico maiores (360)', NULL, 'Unde in eum molestiae impedit facere aperiam quas. Sunt ut tenetur enim quia illum quia magnam iusto. Eligendi illum eum libero fugit sint id voluptatem tenetur.', 46, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(42, 'Antibiótico quae (745)', NULL, 'Rerum est quisquam ut ut architecto. Quia qui corporis rem corporis assumenda odio sed ea.', 75, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(43, 'Antibiótico id (503)', NULL, 'Tempore qui quia ut. Praesentium voluptatem dolores vero natus. Nihil est neque doloremque voluptatem non.', 86, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(44, 'Antiviral quidem (903)', NULL, 'Sed est repellendus minus magnam. Ipsa sit vel ea. Ab a quia optio reiciendis nihil.', 89, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(45, 'Terapia Física voluptatem (606)', NULL, 'Voluptates et molestiae maiores inventore nesciunt aliquam totam. Et repudiandae consequatur corporis rerum deserunt et. Autem quia quia et hic.', 68, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(46, 'Antibiótico temporibus (500)', NULL, 'Molestiae laboriosam possimus minus qui id velit possimus. Non et est saepe nostrum quo iure.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(47, 'Analgésico non (577)', NULL, 'Sit voluptate nostrum harum voluptate eos qui. Qui aut minus autem dolores.', 5, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(48, 'Antiviral molestias (698)', NULL, 'Laboriosam a sit similique non iusto vero. Rerum voluptatem voluptas rem sequi quo et cum. Aliquam veniam eos corrupti enim ipsam cum fuga eligendi.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(49, 'Antibiótico cum (263)', NULL, 'Sit laborum id dolor velit modi. Voluptatibus quia quo consequuntur earum deleniti deserunt.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07'),
(50, 'Terapia Física labore (420)', NULL, 'Ipsum voluptatem placeat natus sed. Perspiciatis doloribus et saepe totam qui odit unde.', NULL, '2025-10-28 13:22:07', '2025-10-28 13:22:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `dni`, `telefono`, `direccion`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'vanesa', 'virtualvmm@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Had5CEZqqIuhQ2TZBlTV2OYcegfab7IUuDKMFG9syN/nooQ2uVrT.', NULL, '2025-11-05 11:39:09', '2025-11-05 11:39:09'),
(2, 'admin', 'admin@example.com', '00000000A', '600000000', 'Administración', NULL, '$2y$10$DjCuyjvJpY/frcUIwTp21.3w6pQXP8IKqU58WX86g.AFzzGJD/ptm', NULL, '2025-11-05 12:39:06', '2025-11-05 12:39:06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alarmas`
--
ALTER TABLE `alarmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alarmas_patogeno_id_foreign` (`patogeno_id`),
  ADD KEY `alarmas_diagnostico_id_foreign` (`diagnostico_id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contactos_user_id_index` (`user_id`);

--
-- Indices de la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnosticos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `fuentes_informacion`
--
ALTER TABLE `fuentes_informacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fuentes_informacion_nombre_unique` (`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `noticias_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `patogenos`
--
ALTER TABLE `patogenos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patogenos_nombre_unique` (`nombre`),
  ADD KEY `patogenos_tipo_patogeno_id_foreign` (`tipo_patogeno_id`),
  ADD KEY `patogenos_fuente_id_fk` (`fuente_id`);

--
-- Indices de la tabla `patogeno_sintoma`
--
ALTER TABLE `patogeno_sintoma`
  ADD PRIMARY KEY (`patogeno_id`,`sintoma_id`),
  ADD KEY `patogeno_sintoma_sintoma_id_foreign` (`sintoma_id`);

--
-- Indices de la tabla `patogeno_tratamiento`
--
ALTER TABLE `patogeno_tratamiento`
  ADD PRIMARY KEY (`patogeno_id`,`tratamiento_id`),
  ADD KEY `patogeno_tratamiento_tratamiento_id_foreign` (`tratamiento_id`);

--
-- Indices de la tabla `patogeno_user`
--
ALTER TABLE `patogeno_user`
  ADD PRIMARY KEY (`patogeno_id`,`user_id`),
  ADD KEY `patogeno_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_nombre_unique` (`nombre`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sintomas_nombre_unique` (`nombre`);

--
-- Indices de la tabla `tipo_patogenos`
--
ALTER TABLE `tipo_patogenos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo_patogenos_nombre_unique` (`nombre`);

--
-- Indices de la tabla `tipo_tratamientos`
--
ALTER TABLE `tipo_tratamientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo_tratamientos_nombre_unique` (`nombre`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tratamientos_nombre_unique` (`nombre`),
  ADD KEY `tratamientos_tipo_id_foreign` (`tipo_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alarmas`
--
ALTER TABLE `alarmas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fuentes_informacion`
--
ALTER TABLE `fuentes_informacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `patogenos`
--
ALTER TABLE `patogenos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sintomas`
--
ALTER TABLE `sintomas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tipo_patogenos`
--
ALTER TABLE `tipo_patogenos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_tratamientos`
--
ALTER TABLE `tipo_tratamientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alarmas`
--
ALTER TABLE `alarmas`
  ADD CONSTRAINT `alarmas_diagnostico_id_foreign` FOREIGN KEY (`diagnostico_id`) REFERENCES `diagnosticos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `alarmas_patogeno_id_foreign` FOREIGN KEY (`patogeno_id`) REFERENCES `patogenos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  ADD CONSTRAINT `diagnosticos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `patogenos`
--
ALTER TABLE `patogenos`
  ADD CONSTRAINT `patogenos_fuente_id_fk` FOREIGN KEY (`fuente_id`) REFERENCES `fuentes_informacion` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patogenos_tipo_patogeno_id_foreign` FOREIGN KEY (`tipo_patogeno_id`) REFERENCES `tipo_patogenos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `patogeno_sintoma`
--
ALTER TABLE `patogeno_sintoma`
  ADD CONSTRAINT `patogeno_sintoma_patogeno_id_foreign` FOREIGN KEY (`patogeno_id`) REFERENCES `patogenos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patogeno_sintoma_sintoma_id_foreign` FOREIGN KEY (`sintoma_id`) REFERENCES `sintomas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `patogeno_tratamiento`
--
ALTER TABLE `patogeno_tratamiento`
  ADD CONSTRAINT `patogeno_tratamiento_patogeno_id_foreign` FOREIGN KEY (`patogeno_id`) REFERENCES `patogenos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patogeno_tratamiento_tratamiento_id_foreign` FOREIGN KEY (`tratamiento_id`) REFERENCES `tratamientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `patogeno_user`
--
ALTER TABLE `patogeno_user`
  ADD CONSTRAINT `patogeno_user_patogeno_id_foreign` FOREIGN KEY (`patogeno_id`) REFERENCES `patogenos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patogeno_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_tipo_id_foreign` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_tratamientos` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
