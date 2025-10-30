-- Site Images Table for Managing All Website Images
-- Admin can upload and manage site images through Admin > Site Images

-- Create site_images table
CREATE TABLE IF NOT EXISTS `site_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_key` varchar(100) NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `image_category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_key` (`image_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default site images
INSERT INTO `site_images` (`image_key`, `image_file`, `alt_text`, `image_category`, `description`, `is_active`) VALUES
-- Homepage Images
('homepage_csr_image', 'csr.png', 'RK Trust Initiatives', 'homepage', 'CSR/RK Trust section image on homepage', 1),

-- About Page Images
('about_partnerships_collage', 'brand-collage.png', 'Partnerships and Brands Collage', 'about', 'Brand partnerships collage image on about page', 1),

-- General Site Images
('site_logo_color', 'RKGroup logo.svg', 'RK Group Logo', 'general', 'Main site logo (color version)', 1),
('site_logo_white', 'RKGroup logo.svg', 'RK Group Logo White', 'general', 'White version of site logo', 1),
('site_favicon', 'RKGroup logo.svg', 'RK Group Favicon', 'general', 'Site favicon', 1);
