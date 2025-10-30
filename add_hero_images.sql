-- Add Hero Background Images to site_images table
-- These allow admin to change hero backgrounds for About, Careers, and Connect pages

INSERT INTO `site_images` (`image_key`, `image_url`, `alt_text`, `image_category`, `description`, `is_active`) VALUES
('about_hero_background', 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&h=1080&fit=crop', 'About Us Hero Background', 'about', 'Hero section background image for About Us page', 1),
('careers_hero_background', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1920&h=1080&fit=crop&q=80', 'Careers Hero Background', 'careers', 'Hero section background image for Careers page', 1),
('connect_hero_background', 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=1920&h=1080&fit=crop&q=80', 'Connect Hero Background', 'connect', 'Hero section background image for Connect With Us page', 1);
