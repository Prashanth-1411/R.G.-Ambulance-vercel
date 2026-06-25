-- R.G. Ambulance Service - Complete Database Schema
-- MySQL 8.0+ / MariaDB 10.3+
-- Engine: InnoDB, Charset: utf8mb4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";

CREATE DATABASE IF NOT EXISTS `rg_ambulance` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `rg_ambulance`;

-- ==========================================
-- ADMIN / AUTH
-- ==========================================
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin','admin','editor') NOT NULL DEFAULT 'admin',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login` DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- SETTINGS
-- ==========================================
CREATE TABLE `settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_name` VARCHAR(191) DEFAULT 'R.G. Ambulance Service',
  `tagline` VARCHAR(255) DEFAULT 'Emergency Medical Services',
  `email` VARCHAR(191) DEFAULT 'ebenezer.r@rgambulanceservice.com',
  `phone_primary` VARCHAR(50) DEFAULT '+91 95516 63530',
  `phone_secondary` VARCHAR(50) DEFAULT '+91 87784 81556',
  `phone_office` VARCHAR(50) DEFAULT '+91 93611 69801',
  `whatsapp` VARCHAR(50) DEFAULT '+91 87784 81556',
  `address` TEXT,
  `city` VARCHAR(100) DEFAULT 'Chennai',
  `state` VARCHAR(100) DEFAULT 'Tamil Nadu',
  `pincode` VARCHAR(20) DEFAULT '600066',
  `logo` VARCHAR(255) DEFAULT NULL,
  `favicon` VARCHAR(255) DEFAULT NULL,
  `logo_width` INT DEFAULT 140,
  `map_embed` TEXT,
  `smtp_host` VARCHAR(191) DEFAULT NULL,
  `smtp_port` INT DEFAULT 587,
  `smtp_user` VARCHAR(191) DEFAULT NULL,
  `smtp_pass` VARCHAR(255) DEFAULT NULL,
  `smtp_from` VARCHAR(191) DEFAULT NULL,
  `facebook` VARCHAR(255) DEFAULT NULL,
  `twitter` VARCHAR(255) DEFAULT NULL,
  `instagram` VARCHAR(255) DEFAULT NULL,
  `linkedin` VARCHAR(255) DEFAULT NULL,
  `youtube` VARCHAR(255) DEFAULT NULL,
  `established_year` VARCHAR(10) DEFAULT '2014',
  `iso_certified` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- NAVIGATION
-- ==========================================
CREATE TABLE `navigation_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `label` VARCHAR(100) NOT NULL,
  `link` VARCHAR(255) NOT NULL,
  `parent_id` INT UNSIGNED DEFAULT NULL,
  `location` ENUM('header','footer') NOT NULL DEFAULT 'header',
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`parent_id`) REFERENCES `navigation_items`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================================
-- PAGE CONTENT (CMS Pages)
-- ==========================================
CREATE TABLE `pages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `page_name` VARCHAR(100) NOT NULL UNIQUE,
  `heading` VARCHAR(255) DEFAULT NULL,
  `subheading` VARCHAR(255) DEFAULT NULL,
  `content` TEXT,
  `hero_image` VARCHAR(255) DEFAULT NULL,
  `hero_video` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- HERO SLIDES
-- ==========================================
CREATE TABLE `hero_slides` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` TEXT,
  `badge_text` VARCHAR(100) DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `video` VARCHAR(255) DEFAULT NULL,
  `button_text` VARCHAR(100) DEFAULT NULL,
  `button_link` VARCHAR(255) DEFAULT NULL,
  `button_text_2` VARCHAR(100) DEFAULT NULL,
  `button_link_2` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- STATISTICS COUNTERS
-- ==========================================
CREATE TABLE `statistics` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `label` VARCHAR(191) NOT NULL,
  `value` INT NOT NULL,
  `suffix` VARCHAR(20) DEFAULT '+',
  `icon` VARCHAR(50) DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- FEATURED SECTIONS (Homepage)
-- ==========================================
CREATE TABLE `featured_sections` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `icon` VARCHAR(50) DEFAULT NULL,
  `title` VARCHAR(191) NOT NULL,
  `description` TEXT,
  `section_type` VARCHAR(50) DEFAULT 'about',
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- SERVICE CATEGORIES
-- ==========================================
CREATE TABLE `service_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `description` TEXT,
  `icon` VARCHAR(50) DEFAULT NULL,
  `service_type` ENUM('ambulance','funeral') NOT NULL DEFAULT 'ambulance',
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- SERVICES
-- ==========================================
CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(191) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `short_description` VARCHAR(255) DEFAULT NULL,
  `description` TEXT,
  `icon` VARCHAR(50) DEFAULT 'ambulance',
  `image` VARCHAR(255) DEFAULT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `service_type` ENUM('ambulance','funeral') NOT NULL DEFAULT 'ambulance',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `service_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================================
-- SERVICE FEATURES
-- ==========================================
CREATE TABLE `service_features` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `service_id` INT UNSIGNED NOT NULL,
  `feature` VARCHAR(255) NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================
-- SERVICE AREAS (Coverage Locations)
-- ==========================================
CREATE TABLE `service_areas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `region` VARCHAR(100) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- SERVICE SPECIFICATIONS
-- ==========================================
CREATE TABLE `service_specifications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `service_id` INT UNSIGNED NOT NULL,
  `spec_key` VARCHAR(100) NOT NULL,
  `spec_value` VARCHAR(255) NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================
-- SERVICE BROCHURES
-- ==========================================
CREATE TABLE `service_brochures` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `service_id` INT UNSIGNED NOT NULL,
  `brochure_file` VARCHAR(255) NOT NULL,
  `brochure_name` VARCHAR(191) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================
-- CAPABILITIES
-- ==========================================
CREATE TABLE `capabilities` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(191) NOT NULL,
  `description` TEXT,
  `image` VARCHAR(255) DEFAULT NULL,
  `icon` VARCHAR(50) DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- SISTER CONCERNS
-- ==========================================
CREATE TABLE `sister_concerns` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_name` VARCHAR(191) NOT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `description` TEXT,
  `website_link` VARCHAR(255) DEFAULT NULL,
  `contact_phone` VARCHAR(50) DEFAULT NULL,
  `contact_email` VARCHAR(191) DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- GALLERY / ALBUMS
-- ==========================================
CREATE TABLE `albums` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(191) NOT NULL,
  `description` TEXT,
  `cover_image` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `gallery_images` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `album_id` INT UNSIGNED DEFAULT NULL,
  `title` VARCHAR(191) DEFAULT NULL,
  `image` VARCHAR(255) NOT NULL,
  `alt_text` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`album_id`) REFERENCES `albums`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================================
-- TESTIMONIALS
-- ==========================================
CREATE TABLE `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `position` VARCHAR(191) DEFAULT NULL,
  `designation` VARCHAR(191) DEFAULT NULL,
  `category` VARCHAR(50) DEFAULT 'ambulance',
  `content` TEXT NOT NULL,
  `rating` TINYINT(1) NOT NULL DEFAULT 5,
  `image` VARCHAR(255) DEFAULT NULL,
  `verification_url` VARCHAR(255) DEFAULT NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- BLOG / POSTS
-- ==========================================
CREATE TABLE `blog_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `blog_posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `content` LONGTEXT,
  `excerpt` TEXT,
  `featured_image` VARCHAR(255) DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `tags` VARCHAR(255) DEFAULT NULL,
  `author` VARCHAR(100) DEFAULT 'R.G. Ambulance Service',
  `reading_time` VARCHAR(50) DEFAULT '5 min read',
  `views` INT UNSIGNED NOT NULL DEFAULT 0,
  `meta_title` VARCHAR(255) DEFAULT NULL,
  `meta_description` TEXT,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `blog_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================================
-- CONTACT INQUIRIES
-- ==========================================
CREATE TABLE `contact_inquiries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `email` VARCHAR(191) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `address` TEXT,
  `subject` VARCHAR(191) DEFAULT NULL,
  `message` TEXT,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('unread','read','replied') NOT NULL DEFAULT 'unread',
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- BOOKINGS
-- ==========================================
CREATE TABLE `bookings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `pickup` VARCHAR(255) DEFAULT NULL,
  `destination` VARCHAR(255) DEFAULT NULL,
  `service_type` VARCHAR(50) DEFAULT 'ambulance',
  `booking_type` VARCHAR(50) DEFAULT 'ambulance',
  `service_name` VARCHAR(191) DEFAULT NULL,
  `booking_date` DATE DEFAULT NULL,
  `notes` TEXT,
  `status` ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- TEAM MEMBERS
-- ==========================================
CREATE TABLE `team_members` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(191) NOT NULL,
  `designation` VARCHAR(191) DEFAULT NULL,
  `bio` TEXT,
  `image` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(191) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- CERTIFICATES & AWARDS
-- ==========================================
CREATE TABLE `certificates` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(191) NOT NULL,
  `issuer` VARCHAR(191) DEFAULT NULL,
  `date_issued` DATE DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `type` ENUM('certificate','award') NOT NULL DEFAULT 'certificate',
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- COMPANY HISTORY / TIMELINE
-- ==========================================
CREATE TABLE `company_timeline` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `year` VARCHAR(10) NOT NULL,
  `title` VARCHAR(191) NOT NULL,
  `description` TEXT,
  `sort_order` INT NOT NULL DEFAULT 0,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- SEO
-- ==========================================
CREATE TABLE `seo_meta` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `page_name` VARCHAR(100) NOT NULL UNIQUE,
  `meta_title` VARCHAR(191) DEFAULT NULL,
  `meta_description` TEXT,
  `meta_keywords` TEXT,
  `og_title` VARCHAR(191) DEFAULT NULL,
  `og_description` TEXT,
  `og_image` VARCHAR(255) DEFAULT NULL,
  `structured_data` TEXT,
  `canonical_url` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================
-- SESSIONS (for admin)
-- ==========================================
CREATE TABLE `sessions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `session_token` VARCHAR(255) NOT NULL UNIQUE,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================
-- ACTIVITY LOGS
-- ==========================================
CREATE TABLE `activity_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `action` VARCHAR(191) NOT NULL,
  `module` VARCHAR(100) DEFAULT NULL,
  `description` TEXT,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================================
-- NOTIFICATIONS
-- ==========================================
CREATE TABLE `notifications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `title` VARCHAR(191) NOT NULL,
  `message` TEXT,
  `type` VARCHAR(50) DEFAULT 'info',
  `module` VARCHAR(100) DEFAULT NULL,
  `reference_id` INT UNSIGNED DEFAULT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================
-- INDEXES
-- ==========================================
CREATE INDEX `idx_services_type` ON `services`(`service_type`);
CREATE INDEX `idx_services_featured` ON `services`(`is_featured`);
CREATE INDEX `idx_blog_posts_status` ON `blog_posts`(`status`);
CREATE INDEX `idx_inquiries_read` ON `contact_inquiries`(`is_read`);
CREATE INDEX `idx_inquiries_status` ON `contact_inquiries`(`status`);
CREATE INDEX `idx_bookings_status` ON `bookings`(`status`);
CREATE INDEX `idx_notifications_user` ON `notifications`(`user_id`, `is_read`);
CREATE INDEX `idx_activity_user` ON `activity_logs`(`user_id`);
CREATE INDEX `idx_activity_created` ON `activity_logs`(`created_at`);

-- ==========================================
-- DEFAULT DATA
-- ==========================================

-- Admin user (password: admin123)
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Super Admin', 'admin@rgambulanceservice.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin');

-- Default settings
INSERT INTO `settings` (`company_name`, `tagline`, `email`, `phone_primary`, `phone_secondary`, `whatsapp`, `address`) VALUES
('R.G. Ambulance Service', 'Emergency Medical Services', 'ebenezer.r@rgambulanceservice.com', '+91 95516 63530', '+91 87784 81556', '+91 87784 81556', '115/2a, Ambattur Road, Surapet, Soorapattu, Ambattur Taluka, Chennai - 600066');

-- Default navigation
INSERT INTO `navigation_items` (`label`, `link`, `sort_order`) VALUES
('Home', '/', 1),
('Ambulance Services', '/ambulance-services', 2),
('Funeral Care', '/funeral-services', 3),
('Testimonials', '/testimonials', 4),
('Blog', '/blog', 5),
('Contact', '/contact', 6);

-- Default pages
INSERT INTO `pages` (`page_name`, `heading`, `content`) VALUES
('home', 'R.G. Ambulance Service', 'Your trusted emergency medical transport provider since 2014.'),
('about', 'Why Healthcare Providers & Families Trust Us', 'In medical emergencies, every second counts. We maintain the highest standards of safety, clinical expertise, and response velocity.'),
('services', 'Professional Emergency Services', 'Equipped with certified medical gear and designed for safety, comfort, and absolute compliance.'),
('contact', 'Contact Our Emergency Desk', 'Our medical coordinators are standing by 24/7. Call, WhatsApp, or send us an inquiry.');

-- Default hero slides
INSERT INTO `hero_slides` (`title`, `subtitle`, `button_text`, `button_link`, `sort_order`) VALUES
('Your Lifeline in Medical Emergencies', 'Rapid response ICU ambulances with advanced life-support equipment. Available 24/7 across Chennai and all major routes.', 'Call 24/7 Hotline', 'tel:+919551663530', 1);

-- Default statistics
INSERT INTO `statistics` (`label`, `value`, `suffix`, `icon`, `sort_order`) VALUES
('Years of Experience', 12, '+', 'Award', 1),
('Active Medical Vehicles', 34, '+', 'Truck', 2),
('Patients Safely Transferred', 8200, '+', 'HeartPulse', 3),
('Service Locations', 100, '%', 'MapPin', 4);

-- Default service categories
INSERT INTO `service_categories` (`name`, `slug`, `service_type`, `sort_order`) VALUES
('Emergency Ambulance', 'emergency-ambulance', 'ambulance', 1),
('Critical Care', 'critical-care', 'ambulance', 2),
('Patient Transport', 'patient-transport', 'ambulance', 3),
('Funeral Transport', 'funeral-transport', 'funeral', 4),
('Ceremony Services', 'ceremony-services', 'funeral', 5),
('Support Services', 'support-services', 'funeral', 6);

-- Default services (Ambulance)
INSERT INTO `services` (`title`, `slug`, `short_description`, `description`, `icon`, `service_type`, `is_featured`, `sort_order`) VALUES
('Basic Life Support Ambulance', 'basic-life-support', 'Emergency transport with basic medical support', 'Our BLS ambulances are equipped with essential life-saving equipment including oxygen cylinders, stretchers, and first-aid kits. Ideal for non-critical patient transport with trained EMTs onboard ensuring patient stability during transit.', 'ambulance', 'ambulance', 1, 1),
('Advanced Life Support Ambulance', 'advanced-life-support', 'ICU-on-wheels with ventilator support', 'Our ALS ambulances function as a mobile ICU, equipped with advanced cardiac monitors, defibrillators, infusion pumps, and mechanical ventilators. Staffed by critical care paramedics for high-acuity patients requiring intensive monitoring during inter-facility transfers.', 'ambulance', 'ambulance', 1, 2),
('Neonatal & Pediatric Ambulance', 'neonatal-pediatric', 'Specialized transport for newborns and children', 'Specially designed ambulances with portable incubators, pediatric ventilators, and temperature-controlled environments. Our NICU-trained staff ensure safe transport of premature babies and children requiring specialized medical attention during transit.', 'ambulance', 'ambulance', 1, 3),
('ICU Ventilator Ambulance', 'icu-ventilator', 'Full ICU setup for critical patient transfer', 'State-of-the-art ICU ambulances featuring advanced life support systems including multi-parameter monitors, ventilators, and critical care medications. Perfect for inter-city or interstate transfers of critically ill patients requiring continuous intensive care.', 'ambulance', 'ambulance', 1, 4),
('Patient Transport Vehicle', 'patient-transport', 'Comfortable non-emergency patient transport', 'Comfortable and accessible transport vehicles for non-emergency medical appointments, discharge transfers, and routine checkups. Our PTVs are equipped with wheelchair ramps, comfortable seating, and basic amenities for patient convenience.', 'ambulance', 'ambulance', 0, 5),
('Long Distance Interstate Ambulance', 'long-distance-interstate', 'Cross-border patient transfer with full medical support', 'Purpose-built ambulances for long-distance interstate transfers featuring extended fuel range, backup oxygen systems, dual-crew rotation, and rest facilities. Fully equipped to handle medical emergencies during multi-state journeys with satellite tracking.', 'ambulance', 'ambulance', 0, 6),
('Cardiac Care Ambulance', 'cardiac-care', 'Heart attack and cardiac emergency response', 'Rapid response cardiac ambulances equipped with 12-lead ECG machines, cardiac monitors, defibrillators, and thrombolytic medications. Our cardiac-trained paramedics work closely with hospital cath labs to provide seamless STEMI care during transport.', 'ambulance', 'ambulance', 1, 7);

-- Default services (Funeral)
INSERT INTO `services` (`title`, `slug`, `short_description`, `description`, `icon`, `service_type`, `is_featured`, `sort_order`) VALUES
('Hi-Tech Air Conditioned Funeral Van', 'ac-funeral-van', 'AC hearse van for dignified last journey', 'Our air-conditioned funeral vans provide a dignified and comfortable final journey for the departed. Featuring temperature-controlled interiors, elegant décor, and professional attendants who ensure the highest standards of respect and care throughout the procession.', 'heart', 'funeral', 1, 1),
('Deceased Freezer Box / ICE Box', 'deceased-freezer-box', 'Cold storage preservation for extended periods', 'Industrial-grade deceased freezer boxes designed for temporary preservation and transportation of mortal remains. Ideal for long-distance transfers, legal formalities, or delays in funeral arrangements. Maintains optimal temperature with backup power support.', 'heart', 'funeral', 1, 2),
('Motorized Coffin Lowering Equipment', 'coffin-lowering', 'Mechanized lowering system for graveside services', 'Motorized coffin lowering equipment ensuring smooth and dignified lowering during burial ceremonies. Our battery-operated systems provide controlled descent with remote operation, eliminating manual handling and ensuring complete respect during the final rites.', 'heart', 'funeral', 0, 3),
('VIP Funeral Arrangements', 'vip-funeral', 'Premium homage services with full ceremonial support', 'Comprehensive VIP funeral packages designed for dignitaries, public figures, and families seeking the highest level of ceremonial respect. Includes luxury hearse, floral arrangements, motorcade coordination, and dedicated funeral directors managing every aspect.', 'heart', 'funeral', 1, 4),
('Casket & Urn Selection', 'casket-urn-selection', 'Wide range of coffins, caskets, and urns', 'Browse our carefully curated selection of coffins, caskets, and memorial urns. From traditional wooden coffins to eco-friendly options and premium metal caskets with custom engravings. Our counselors help families choose the appropriate memorial for their loved ones.', 'heart', 'funeral', 0, 5),
('Death Certificate & Legal Assistance', 'death-certificate-assistance', 'Help with documentation and legal formalities', 'Compassionate guidance through the complex legal processes following a demise. Our team assists with death certificate registration, police intimation, insurance claim documentation, and other statutory requirements, allowing families to focus on mourning and remembrance.', 'heart', 'funeral', 0, 6),
('Religious & Cultural Ceremony Support', 'religious-cultural-support', 'Respecting diverse traditions and customs', 'Our team is experienced in conducting funerals according to various religious and cultural traditions including Hindu, Christian, Muslim, Sikh, and Jain customs. We coordinate with priests, church authorities, and community leaders to ensure all rituals are properly observed.', 'heart', 'funeral', 0, 7),
('Dead Body Transport Services', 'dead-body-transport', 'Inter-city and interstate mortal remains transport', 'Specialized dead body transportation services for moving mortal remains between cities, states, or countries. Our fleet of freezer-equipped vehicles and professional handling staff ensure dignified transport with all necessary documentation and embalming support.', 'heart', 'funeral', 0, 8);

-- Service features
INSERT INTO `service_features` (`service_id`, `feature`, `sort_order`) VALUES
(1, 'Oxygen Cylinder', 1), (1, 'Stretcher with Lock', 2), (1, 'First Aid Kit', 3), (1, 'Trained EMT', 4), (1, 'GPS Tracking', 5), (1, 'Mobile Ventilator Ready', 6),
(2, 'Cardiac Monitor', 1), (2, 'Defibrillator', 2), (2, 'Infusion Pump', 3), (2, 'Mechanical Ventilator', 4), (2, 'Multi-parameter Monitor', 5), (2, 'Suction Machine', 6),
(3, 'Portable Incubator', 1), (3, 'Pediatric Ventilator', 2), (3, 'Temperature Control', 3), (3, 'Neonatal Monitor', 4), (3, 'Pediatric Drug Kit', 5), (3, 'Trained Neonatal Nurse', 6),
(4, 'ICU Ventilator', 1), (4, 'Multi-parameter Monitor', 2), (4, 'Defibrillator', 3), (4, 'Infusion Pumps', 4), (4, 'Central Oxygen Supply', 5), (4, 'Critical Care Paramedic', 6),
(5, 'Wheelchair Ramp', 1), (5, 'Comfort Seating', 2), (5, 'AC Comfort', 3), (5, 'Trained Attendant', 4), (5, 'Stretcher', 5), (5, 'GPS Tracking', 6),
(6, 'Extended Fuel Range', 1), (6, 'Backup Oxygen', 2), (6, 'Dual Crew Rotation', 3), (6, 'Satellite Tracking', 4), (6, 'Long-range Comms', 5), (6, 'Emergency Medicines Kit', 6),
(7, '12-lead ECG', 1), (7, 'Cardiac Monitor', 2), (7, 'Defibrillator', 3), (7, 'Thrombolytic Drugs', 4), (7, 'Cardiac-trained Paramedic', 5), (7, 'Cath Lab Integration', 6),
(8, 'AC Temperature Control', 1), (8, 'Elegant Interior Décor', 2), (8, 'Professional Attendants', 3), (8, 'GPS Tracked Procession', 4), (8, 'Spacious Compartment', 5), (8, 'Respectful Handling', 6),
(9, 'Temperature Controlled', 1), (9, 'Backup Power Support', 2), (9, 'Portable Design', 3), (9, 'Long Duration Storage', 4), (9, 'Hygienic Interior', 5), (9, 'Easy Loading System', 6),
(10, 'Battery Operated', 1), (10, 'Remote Control', 2), (10, 'Smooth Descent', 3), (10, 'Load Capacity 300kg', 4), (10, 'Portable Setup', 5), (10, 'Silent Operation', 6),
(11, 'Luxury Hearse', 1), (11, 'Floral Arrangements', 2), (11, 'Motorcade Coordination', 3), (11, 'Dedicated Funeral Director', 4), (11, 'Ceremonial Support', 5), (11, 'Media Management', 6),
(12, 'Wooden Coffins', 1), (12, 'Metal Caskets', 2), (12, 'Eco-friendly Options', 3), (12, 'Custom Engraving', 4), (12, 'Memorial Urns', 5), (12, 'Expert Counseling', 6),
(13, 'Death Certificate Support', 1), (13, 'Police Intimation', 2), (13, 'Insurance Documentation', 3), (13, 'Legal Guidance', 4), (13, 'Document Collection', 5), (13, 'Family Liaison', 6),
(14, 'Multi-faith Support', 1), (14, 'Priest Coordination', 2), (14, 'Ritual Arrangements', 3), (14, 'Community Liaison', 4), (14, 'Tradition Guidance', 5), (14, 'Pandit/Pastor Booking', 6),
(15, 'Freezer Transport', 1), (15, 'Embalming Support', 2), (15, 'Documentation Help', 3), (15, 'Inter-state Service', 4), (15, 'Airport Transfer', 5), (15, '24/7 Coordination', 6);

-- Default blog categories
INSERT INTO `blog_categories` (`name`, `slug`) VALUES
('Emergency Guide', 'emergency-guide'),
('Medical Transport', 'medical-transport'),
('Patient Transport', 'patient-transport'),
('Funeral Care', 'funeral-care'),
('Legal', 'legal');

-- Default blog posts
INSERT INTO `blog_posts` (`title`, `slug`, `content`, `category_id`, `tags`, `meta_title`, `meta_description`, `status`, `created_at`) VALUES
('When to Call an Ambulance: A Comprehensive Guide for Emergency Situations', 'when-to-call-ambulance-guide',
'Every second counts during a medical emergency. Knowing when to call an ambulance can mean the difference between life and death. Here is a comprehensive guide to help you recognize emergencies that require immediate professional medical transport.\n\n## Warning Signs That Require an Ambulance\n\n**Chest Pain or Discomfort** — If someone experiences chest pain, pressure, or discomfort lasting more than two minutes, especially accompanied by shortness of breath, cold sweat, or nausea, call an ambulance immediately. This could indicate a heart attack.\n\n**Difficulty Breathing** — Sudden difficulty breathing, wheezing, or choking requires emergency medical intervention. Ambulances carry oxygen and respiratory support equipment.\n\n**Severe Bleeding** — If bleeding does not stop with direct pressure after 10 minutes, or if the wound appears deep and may have damaged arteries, call for emergency transport.\n\n**Loss of Consciousness** — Fainting, seizures, or unresponsiveness require immediate medical evaluation.\n\n**Severe Allergic Reactions** — Swelling of the face, throat, or tongue following an allergy exposure can quickly become life-threatening.\n\n**Head Injuries** — Any head injury accompanied by confusion, vomiting, or loss of consciousness needs emergency assessment.\n\n**Stroke Symptoms** — Use the FAST method: Facial drooping, Arm weakness, Speech difficulties, Time to call emergency services.\n\n## Why Choose Professional Ambulance Transport\n\nSelf-transporting to a hospital can be dangerous. Ambulances provide:\n- Medical care during transit\n- Traffic navigation with sirens\n- Communication with receiving hospitals\n- Equipment for life support if condition deteriorates\n\nAt R.G. Ambulance Service, our fleet is available 24/7 with trained paramedics and advanced life-support equipment ready for immediate dispatch.',
1, 'ambulance, emergency, when to call, medical emergency, first aid',
'When to Call an Ambulance | Emergency Guide | R.G. Ambulance Service',
'Learn when to call an ambulance in emergency situations. Complete guide covering heart attacks, strokes, accidents, and other medical emergencies.',
1, '2026-06-01 10:00:00');

-- Default testimonials
INSERT INTO `testimonials` (`name`, `designation`, `category`, `content`, `rating`, `is_approved`, `sort_order`) VALUES
('Aravind Krishnan', 'Patient Family Member', 'ambulance', 'My father suffered a heart attack at 2 AM. R.G. Ambulance reached our home in 12 minutes. The paramedics were professional, calm, and handled everything perfectly. They saved my father life with their rapid response.', 5, 1, 1),
('Padmini Rajan', 'Hospital Administrator', 'icu', 'We have partnered with R.G. Ambulance Service for over 5 years for our inter-hospital ICU transfers. Their ventilators and critical care teams match our ICU standards. Highly reliable and professionally managed.', 5, 1, 2),
('David Joseph', 'Funeral Service User', 'funeral', 'During our time of grief, R.G. Ambulance provided dignified and respectful funeral transport services. The attendants were compassionate and handled everything with care. They made a difficult day a little easier.', 5, 1, 3),
('Meena Suresh', 'Patient Family', 'long', 'We needed to transport my bedridden mother from Chennai to Madurai. The long-distance ambulance was well-equipped and the crew took excellent care of her throughout the 8-hour journey. Thank you for the safe trip.', 5, 1, 4),
('Dr. Karthik R', 'Referring Physician', 'ambulance', 'I recommend R.G. Ambulance to all my patients requiring emergency transport. Their response time is excellent and the paramedics are well-trained in handling critical cases during transit.', 5, 1, 5);

-- Default service areas (locations from the React data)
INSERT INTO `service_areas` (`name`, `slug`, `region`, `is_active`, `sort_order`) VALUES
('Anna Nagar', 'anna-nagar', 'Chennai', 1, 1),
('T Nagar', 't-nagar', 'Chennai', 1, 2),
('Adyar', 'adyar', 'Chennai', 1, 3),
('Velachery', 'velachery', 'Chennai', 1, 4),
('Porur', 'porur', 'Chennai', 1, 5),
('Guindy', 'guindy', 'Chennai', 1, 6),
('Chromepet', 'chromepet', 'Chennai', 1, 7),
('Tambaram', 'tambaram', 'Chennai', 1, 8),
('Pallavaram', 'pallavaram', 'Chennai', 1, 9),
('Ambattur', 'ambattur', 'Chennai', 1, 10),
('Avadi', 'avadi', 'Chennai', 1, 11),
('Thiruvallur', 'thiruvallur', 'Chennai', 1, 12),
('Kanchipuram', 'kanchipuram', 'Kanchipuram', 1, 13),
('Chengalpattu', 'chengalpattu', 'Chengalpattu', 1, 14),
('Vellore', 'vellore', 'Vellore', 1, 15),
('Tirupattur', 'tirupattur', 'Tirupattur', 1, 16);
