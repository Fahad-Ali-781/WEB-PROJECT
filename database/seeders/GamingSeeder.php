<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class GamingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gamingPcs = Category::updateOrCreate([
            'slug' => 'gaming-pcs',
        ], [
            'name' => 'Gaming PCs',
            'slug' => 'gaming-pcs',
            'description' => 'High-end custom desktops built for competitive and AAA gaming.',
            'image' => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?auto=format&fit=crop&w=1200&q=80',
        ]);

        $gamingTvs = Category::updateOrCreate([
            'slug' => 'gaming-tvs',
        ], [
            'name' => 'Gaming TVs',
            'slug' => 'gaming-tvs',
            'description' => 'Low-latency 4K and OLED TVs designed for immersive gaming.',
            'image' => 'https://images.unsplash.com/photo-1600432129488-fe1caa76aa6f?auto=format&fit=crop&w=1200&q=80',
        ]);

        $gamingConsoles = Category::updateOrCreate([
            'slug' => 'gaming-consoles',
        ], [
            'name' => 'Gaming Consoles',
            'slug' => 'gaming-consoles',
            'description' => 'PS5, Xbox, and other next-generation gaming consoles.',
            'image' => 'https://images.unsplash.com/photo-1605901309584-818e25960a8f?auto=format&fit=crop&w=1200&q=80',
        ]);

        $controllers = Category::updateOrCreate([
            'slug' => 'controllers',
        ], [
            'name' => 'Controllers',
            'slug' => 'controllers',
            'description' => 'Wired and wireless controllers for console and PC gaming.',
            'image' => 'https://images.unsplash.com/photo-1592840062661-6f4d9b43d3f4?auto=format&fit=crop&w=1200&q=80',
        ]);

        $gamingMice = Category::updateOrCreate([
            'slug' => 'gaming-mouse',
        ], [
            'name' => 'Gaming Mouse',
            'slug' => 'gaming-mouse',
            'description' => 'High-DPI gaming mice with precise tracking and low latency.',
            'image' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=1200&q=80',
        ]);

        $gamingKeyboards = Category::updateOrCreate([
            'slug' => 'gaming-keyboards',
        ], [
            'name' => 'Gaming Keyboards',
            'slug' => 'gaming-keyboards',
            'description' => 'Mechanical gaming keyboards with RGB lighting and macro support.',
            'image' => 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?auto=format&fit=crop&w=1200&q=80',
        ]);

        Product::updateOrCreate([
            'slug' => 'rog-strix-gaming-pc-rtx-4080',
        ], [
            'category_id' => $gamingPcs->id,
            'name' => 'ROG Strix Gaming PC RTX 4080',
            'slug' => 'rog-strix-gaming-pc-rtx-4080',
            'description' => 'Intel Core i9 desktop with RTX 4080, 32GB RAM, and 2TB NVMe SSD.',
            'price' => 519999,
            'stock' => 6,
            'city' => 'Karachi',
            'is_featured' => true,
            'image' => 'https://static.webx.pk/files/2603/Images/budget-build-1.0-12-2603-2254642-211124011657411-2603-2256582-180825024838503.webp',
        ]);

        Product::updateOrCreate([
            'slug' => 'amd-ryzen-7-gaming-pc-rtx-4070',
        ], [
            'category_id' => $gamingPcs->id,
            'name' => 'AMD Ryzen 7 Gaming PC RTX 4070',
            'slug' => 'amd-ryzen-7-gaming-pc-rtx-4070',
            'description' => 'Ryzen 7 tower with RTX 4070 for high FPS 1440p gaming.',
            'price' => 379999,
            'stock' => 10,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'https://megatech.pk/wp-content/uploads/2024/11/a3875761-f358-4df8-b18d-153dcea4a622-removebg-preview-1.png',
        ]);

        Product::updateOrCreate([
            'slug' => 'lg-oled-c4-55-gaming-tv',
        ], [
            'category_id' => $gamingTvs->id,
            'name' => 'LG OLED C4 55" Gaming TV',
            'slug' => 'lg-oled-c4-55-gaming-tv',
            'description' => '4K OLED TV with 120Hz refresh rate, VRR, and ultra-low input lag.',
            'price' => 289999,
            'stock' => 12,
            'city' => 'Islamabad',
            'is_featured' => true,
            'image' => 'https://shandaarbuy.pk/cdn/shop/files/TCLC745QLEDGamingTVLEFT.webp?v=1714470619',
        ]);

        Product::updateOrCreate([
            'slug' => 'samsung-qn90d-65-gaming-tv',
        ], [
            'category_id' => $gamingTvs->id,
            'name' => 'Samsung QN90D 65" Gaming TV',
            'slug' => 'samsung-qn90d-65-gaming-tv',
            'description' => '4K Neo QLED TV with HDMI 2.1, Game Mode Pro, and bright HDR.',
            'price' => 349999,
            'stock' => 8,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://aws-obg-image-lb-2.tcl.com/content/dam/brandsite/global/product/tv/c/c635/product-image/c735-logo.png?t=1661335632341&w=800&webp=true&dpr=2.625&rendition=1068',
        ]);

        Product::updateOrCreate([
            'slug' => 'sony-playstation-5-slim',
        ], [
            'category_id' => $gamingConsoles->id,
            'name' => 'Sony PlayStation 5 Slim',
            'slug' => 'sony-playstation-5-slim',
            'description' => 'PS5 Slim console with ultra-fast SSD and ray tracing support.',
            'price' => 179999,
            'stock' => 20,
            'city' => 'Lahore',
            'is_featured' => true,
            'image' => 'https://bnwcollections.com/uploads/products/1691832757Sony%20PlayStation%205%20Gaming%20Console-bnw_11zon.webp',
        ]);

        Product::updateOrCreate([
            'slug' => 'microsoft-xbox-series-x-1tb',
        ], [
            'category_id' => $gamingConsoles->id,
            'name' => 'Microsoft Xbox Series X 1TB',
            'slug' => 'microsoft-xbox-series-x-1tb',
            'description' => 'Xbox Series X with true 4K gaming and a high-speed 1TB SSD.',
            'price' => 169999,
            'stock' => 18,
            'city' => 'Islamabad',
            'is_featured' => true,
            'image' => 'https://gameforce.pk/wp-content/uploads/2024/02/Microsoft-Xbox-Series-X-EEZEPC-1.jpeg',
        ]);

        Product::updateOrCreate([
            'slug' => 'xbox-series-s-512gb',
        ], [
            'category_id' => $gamingConsoles->id,
            'name' => 'Xbox Series S 512GB',
            'slug' => 'xbox-series-s-512gb',
            'description' => 'Compact next-gen console with up to 1440p gaming performance.',
            'price' => 99999,
            'stock' => 22,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://cms-assets.xboxservices.com/assets/68/a0/68a0e50d-0d13-42b1-8498-e55cef8a9133.png?n=642227_Hero-Gallery-0_A2_857x676.png',
        ]);

        Product::updateOrCreate([
            'slug' => 'sony-dualsense-wireless-controller',
        ], [
            'category_id' => $controllers->id,
            'name' => 'Sony DualSense Wireless Controller',
            'slug' => 'sony-dualsense-wireless-controller',
            'description' => 'Adaptive triggers and haptic feedback for immersive gameplay.',
            'price' => 23999,
            'stock' => 40,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://m.media-amazon.com/images/I/51Iuc4URYML._AC_SL1100_.jpg',
        ]);

        Product::updateOrCreate([
            'slug' => 'xbox-wireless-controller-carbon-black',
        ], [
            'category_id' => $controllers->id,
            'name' => 'Xbox Wireless Controller Carbon Black',
            'slug' => 'xbox-wireless-controller-carbon-black',
            'description' => 'Textured grip and Bluetooth support for console, PC, and mobile.',
            'price' => 21999,
            'stock' => 46,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'http://www.pakbyte.pk/cdn/shop/collections/dualsense-thumbnail-ps5-01-en-17jul20-1.jpg?v=1727471665',
        ]);

        Product::updateOrCreate([
            'slug' => 'logitech-g-pro-x-superlight-2',
        ], [
            'category_id' => $gamingMice->id,
            'name' => 'Logitech G Pro X Superlight 2',
            'slug' => 'logitech-g-pro-x-superlight-2',
            'description' => 'Ultra-light esports mouse with HERO sensor and low-latency wireless.',
            'price' => 31999,
            'stock' => 32,
            'city' => 'Islamabad',
            'is_featured' => true,
            'image' => 'https://generations.com.pk/wp-content/uploads/2024/12/T1-T2-Wireless-Gaming-Mouse-by-generations.com_.pk_.jpg',
        ]);

        Product::updateOrCreate([
            'slug' => 'razer-deathadder-v3-pro',
        ], [
            'category_id' => $gamingMice->id,
            'name' => 'Razer DeathAdder V3 Pro',
            'slug' => 'razer-deathadder-v3-pro',
            'description' => 'Ergonomic wireless gaming mouse with optical switches and 30K DPI.',
            'price' => 28999,
            'stock' => 28,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://pakistanstore.pk/wp-content/uploads/2024/12/Xtrike-Me-GM520-RGB-Gaming-Mouse.jpg',
        ]);

        Product::updateOrCreate([
            'slug' => 'corsair-k70-rgb-pro-mechanical-keyboard',
        ], [
            'category_id' => $gamingKeyboards->id,
            'name' => 'Corsair K70 RGB Pro Mechanical Keyboard',
            'slug' => 'corsair-k70-rgb-pro-mechanical-keyboard',
            'description' => 'Tournament-grade mechanical keyboard with per-key RGB and macro keys.',
            'price' => 35999,
            'stock' => 24,
            'city' => 'Lahore',
            'is_featured' => true,
            'image' => 'https://static.webx.pk/files/19643/Images/razer-blackwidow-v4-x-keyboard-price-in-pakistan-1-19643-0-061023090304782.jpg',
        ]);

        Product::updateOrCreate([
            'slug' => 'steelseries-apex-pro-tkl-wireless',
        ], [
            'category_id' => $gamingKeyboards->id,
            'name' => 'SteelSeries Apex Pro TKL Wireless',
            'slug' => 'steelseries-apex-pro-tkl-wireless',
            'description' => 'Tenkeyless adjustable-switch keyboard for fast and accurate inputs.',
            'price' => 42999,
            'stock' => 16,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://www.cherry.de/fileadmin/_processed_/9/8/csm_734d313c3a90b7f62df518410c4575db_8ce247f3e9.jpg',
        ]);

        // Additional Gaming PC
        Product::updateOrCreate([
            'slug' => 'msi-trident-x-plus-rtx-4090',
        ], [
            'category_id' => $gamingPcs->id,
            'name' => 'MSI Trident X Plus RTX 4090',
            'slug' => 'msi-trident-x-plus-rtx-4090',
            'description' => 'Ultra-premium compact gaming PC with RTX 4090 and i9 CPU.',
            'price' => 599999,
            'stock' => 4,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://static.cybertron.com/clx/home/pcs-laps-section/custom-gaming-pcs.jpg',
        ]);

        Product::updateOrCreate([
            'slug' => 'alienware-aurora-r16-gaming-pc',
        ], [
            'category_id' => $gamingPcs->id,
            'name' => 'Alienware Aurora R16 Gaming PC',
            'slug' => 'alienware-aurora-r16-gaming-pc',
            'description' => 'Premium gaming desktop with RTX 4080 and LED customization.',
            'price' => 449999,
            'stock' => 5,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'https://techmatched.pk/wp-content/uploads/2025/04/Darkflash-DY470-Pink-Front-1.webp',
        ]);

        Product::updateOrCreate([
            'slug' => 'nzxt-starter-pro-gaming-pc',
        ], [
            'category_id' => $gamingPcs->id,
            'name' => 'NZXT Starter Pro Gaming PC',
            'slug' => 'nzxt-starter-pro-gaming-pc',
            'description' => 'Affordable RGB gaming tower with RTX 4060 Ti and Ryzen 5.',
            'price' => 249999,
            'stock' => 12,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://img.drz.lazcdn.com/static/pk/p/1919525e71532cef65c6d743ae4f4315.jpg_720x720q80.jpg',
        ]);

        // Additional Gaming TVs
        Product::updateOrCreate([
            'slug' => 'sony-bravia-xr-55-gaming-tv',
        ], [
            'category_id' => $gamingTvs->id,
            'name' => 'Sony BRAVIA XR 55" Gaming TV',
            'slug' => 'sony-bravia-xr-55-gaming-tv',
            'description' => 'Premium 4K TV with XR processor and gaming-optimized refresh rates.',
            'price' => 269999,
            'stock' => 9,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'https://images.philips.com/is/image/philipsconsumer/791cbe4178f940b2abc6b15b014822c1?wid=700&hei=700&$pnglarge$',
        ]);

        Product::updateOrCreate([
            'slug' => 'tcl-qled-65-gaming-tv',
        ], [
            'category_id' => $gamingTvs->id,
            'name' => 'TCL QLED 65" Gaming TV',
            'slug' => 'tcl-qled-65-gaming-tv',
            'description' => 'Budget-friendly 4K QLED TV with 120Hz and low input lag.',
            'price' => 149999,
            'stock' => 14,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://images.samsung.com/is/image/samsung/assets/in/tvs/gaming-tv/2024-gaming-tv-highlight-f14-outro-banner-mo.jpg?$720_N_JPG$',
        ]);

        Product::updateOrCreate([
            'slug' => 'lg-qned99-75-gaming-tv',
        ], [
            'category_id' => $gamingTvs->id,
            'name' => 'LG QNED99 75" Gaming TV',
            'slug' => 'lg-qned99-75-gaming-tv',
            'description' => 'Massive 75-inch flagship gaming TV with mini-LED and 120Hz.',
            'price' => 399999,
            'stock' => 6,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://wise-tech.com.pk/wp-content/uploads/2023/09/32-Asus-ROG-Strix-XG32AQ-Gaming-LED-Monitor-Front-0.png',
        ]);

        // Additional Gaming Consoles
        Product::updateOrCreate([
            'slug' => 'nintendo-switch-oled-white',
        ], [
            'category_id' => $gamingConsoles->id,
            'name' => 'Nintendo Switch OLED White',
            'slug' => 'nintendo-switch-oled-white',
            'description' => 'Hybrid console with vibrant OLED display and docking station.',
            'price' => 89999,
            'stock' => 30,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://i5.walmartimages.com/seo/Nintendo-Switch-Gaming-Console-with-Gray-Joy-Con_903b56b9-ae30-4b14-b9f8-484e05d139f2.599be4c594d4e2cef433ab26f97706a9.jpeg',
        ]);

        Product::updateOrCreate([
            'slug' => 'playstation-5-digital-edition',
        ], [
            'category_id' => $gamingConsoles->id,
            'name' => 'PlayStation 5 Digital Edition',
            'slug' => 'playstation-5-digital-edition',
            'description' => 'All-digital PS5 console perfect for purchasing games online.',
            'price' => 159999,
            'stock' => 16,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'http://games4u.pk/cdn/shop/files/PS5_Pr-Plus_1.jpg?v=1742818252',
        ]);

        Product::updateOrCreate([
            'slug' => 'xbox-series-s-512gb',
        ], [
            'category_id' => $gamingConsoles->id,
            'name' => 'Xbox Series S 512GB',
            'slug' => 'xbox-series-s-512gb',
            'description' => 'Compact next-gen console with up to 1440p gaming performance.',
            'price' => 99999,
            'stock' => 22,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://cms-assets.xboxservices.com/assets/68/a0/68a0e50d-0d13-42b1-8498-e55cef8a9133.png?n=642227_Hero-Gallery-0_A2_857x676.png',
        ]);

        // Additional Controllers
        Product::updateOrCreate([
            'slug' => '8bitdo-ultimate-wireless-controller',
        ], [
            'category_id' => $controllers->id,
            'name' => '8BitDo Ultimate Wireless Controller',
            'slug' => '8bitdo-ultimate-wireless-controller',
            'description' => 'Retro-inspired wireless controller compatible with multiple systems.',
            'price' => 14999,
            'stock' => 35,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'https://static-01.daraz.pk/p/90f6db58bae54233c92a3517f2443150.jpg',
        ]);

        Product::updateOrCreate([
            'slug' => 'hyperx-clutch-pro-controller',
        ], [
            'category_id' => $controllers->id,
            'name' => 'HyperX Clutch Pro Controller',
            'slug' => 'hyperx-clutch-pro-controller',
            'description' => 'Professional-grade controller with customizable buttons and triggers.',
            'price' => 18999,
            'stock' => 28,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://static-01.daraz.pk/p/f62383a5b097854dea01608d420beea2.png',
        ]);

        Product::updateOrCreate([
            'slug' => 'powera-enhanced-controller',
        ], [
            'category_id' => $controllers->id,
            'name' => 'PowerA Enhanced Wired Controller',
            'slug' => 'powera-enhanced-controller',
            'description' => 'Affordable wired gaming controller with traditional button layout.',
            'price' => 9999,
            'stock' => 50,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://i0.wp.com/pclab.pk/wp-content/uploads/2025/09/EasySMX-D05-Multiplatform-Gaming-Controller-with-Charging-Dock-Hall-Effect-Joysticks-and-Triggers-PC-Lab-www.pclab_.pk_.webp?fit=1000%2C1000&ssl=1',
        ]);

        // Additional Gaming Mice
        Product::updateOrCreate([
            'slug' => 'steelseries-rival-600-gaming-mouse',
        ], [
            'category_id' => $gamingMice->id,
            'name' => 'SteelSeries Rival 600 Gaming Mouse',
            'slug' => 'steelseries-rival-600-gaming-mouse',
            'description' => 'Premium wired gaming mouse with TrueMove optical sensor.',
            'price' => 24999,
            'stock' => 18,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'http://www.redragonpakistan.pk/cdn/shop/files/Redragon-M990-Legend-Chroma-MMO-RGB-Gaming-Mouse-Front.jpg?v=1753163808',
        ]);

        Product::updateOrCreate([
            'slug' => 'corsair-dark-core-pro-rgb',
        ], [
            'category_id' => $gamingMice->id,
            'name' => 'Corsair Dark Core Pro RGB',
            'slug' => 'corsair-dark-core-pro-rgb',
            'description' => 'Wireless gaming mouse with wireless charging dock included.',
            'price' => 27999,
            'stock' => 14,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://www.mytrendyphone.eu/images/6D-4-Speed-DPI-RGB-Gaming-Mouse-G5-Black-05042021-01-p.webp',
        ]);

        Product::updateOrCreate([
            'slug' => 'finalmouse-ultralight-2-gaming-mouse',
        ], [
            'category_id' => $gamingMice->id,
            'name' => 'FinalMouse UltraLight 2 Gaming Mouse',
            'slug' => 'finalmouse-ultralight-2-gaming-mouse',
            'description' => 'Lightweight esports mouse under 60 grams with precision tracking.',
            'price' => 29999,
            'stock' => 20,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://i.ebayimg.com/images/g/dh8AAOSw1ttntw5L/s-l400.jpg',
        ]);

        // Additional Gaming Keyboards
        Product::updateOrCreate([
            'slug' => 'ducky-one-3-mechanical-keyboard',
        ], [
            'category_id' => $gamingKeyboards->id,
            'name' => 'Ducky One 3 Mechanical Keyboard',
            'slug' => 'ducky-one-3-mechanical-keyboard',
            'description' => 'Premium full-size mechanical keyboard with Cherry MX switches.',
            'price' => 38999,
            'stock' => 11,
            'city' => 'Karachi',
            'is_featured' => false,
            'image' => 'https://wise-tech.com.pk/wp-content/uploads/2023/07/B875N-800x800.png.webp',
        ]);

        Product::updateOrCreate([
            'slug' => 'hyperx-alloy-elite-gaming-keyboard',
        ], [
            'category_id' => $gamingKeyboards->id,
            'name' => 'HyperX Alloy Elite Mechanical Keyboard',
            'slug' => 'hyperx-alloy-elite-gaming-keyboard',
            'description' => 'Aluminum frame gaming keyboard with mechanical Red switches.',
            'price' => 32999,
            'stock' => 19,
            'city' => 'Lahore',
            'is_featured' => false,
            'image' => 'https://www.technoo.pk/cdn/shop/files/Redragon-S151-Black-Membrane-Gaming-Keyboard-_-Mouse-Wired-Combo-Right-Side-View.webp?v=1754733215&width=720',
        ]);

        Product::updateOrCreate([
            'slug' => 'razer-blackwidow-v4-pro-gaming-keyboard',
        ], [
            'category_id' => $gamingKeyboards->id,
            'name' => 'Razer BlackWidow V4 Pro Gaming Keyboard',
            'slug' => 'razer-blackwidow-v4-pro-gaming-keyboard',
            'description' => 'Full-size mechanical gaming keyboard with Razer Switches.',
            'price' => 45999,
            'stock' => 13,
            'city' => 'Islamabad',
            'is_featured' => false,
            'image' => 'https://www.redragonpakistan.pk/cdn/shop/products/IihnWnqjZXHBk0IRqLLlill0qB21VtoXVYYX6Ue4_2048x2048_b4299781-9d64-4efa-b65e-3fc4fd859ea0.webp?v=1753873622',
        ]);

    }
}
