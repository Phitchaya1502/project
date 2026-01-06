import { Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { ProductListComponent } from './components/product-list/product-list.component';
import { SaleComponent } from './components/sale/sale.component';
import { WishlistComponent } from './components/wishlist/wishlist.component';
import { CartComponent } from './components/cart/cart.component';
import { InfoPageComponent } from './components/info-page/info-page.component';

export const AppRoutes: Routes = [
    { path: '', component: HomeComponent, title: 'Aura Run - Home' },
    { path: 'category/:name', component: ProductListComponent, title: 'Aura Run - Products' },
    { path: 'sale', component: SaleComponent, title: 'Aura Run - Sale' },
    { path: 'wishlist', component: WishlistComponent, title: 'Aura Run - Wishlist' },
    { path: 'cart', component: CartComponent, title: 'Aura Run - Cart' },
    // Footer Routes
    { path: 'find-a-store', component: InfoPageComponent, data: { title: 'Find a Store', content: 'ค้นหาสาขา Aura Run ใกล้บ้านคุณได้อย่างง่ายดาย เพียงป้อนรหัสไปรษณีย์หรือชื่อเมืองของคุณในช่องค้นหาด้านล่าง เรามีสาขาพร้อมให้บริการทั่วประเทศ พร้อมทีมงานผู้เชี่ยวชาญที่คอยให้คำแนะนำเกี่ยวกับผลิตภัณฑ์ที่เหมาะกับคุณที่สุด' } },
    { path: 'membership', component: InfoPageComponent, data: { title: 'Become a Member', content: 'เข้าร่วมเป็นสมาชิก Aura Run วันนี้เพื่อรับสิทธิประโยชน์สุดพิเศษ! สมาชิกจะได้รับส่วนลดพิเศษ, การเข้าถึงสินค้าคอลเลคชั่นใหม่ก่อนใคร, คำเชิญเข้าร่วมกิจกรรมพิเศษ และบริการจัดส่งฟรีทุกคำสั่งซื้อ สมัครฟรี ไม่มีค่าใช้จ่าย!' } },
    { path: 'feedback', component: InfoPageComponent, data: { title: 'Send Us Feedback', content: 'เราให้ความสำคัญกับความคิดเห็นของคุณเป็นอย่างยิ่ง ไม่ว่าจะเป็นคำชม, ข้อเสนอแนะ, หรือเรื่องที่ต้องการให้เราปรับปรุง กรุณากรอกแบบฟอร์มด้านล่างเพื่อส่งข้อความถึงเราโดยตรง ทุกความคิดเห็นของท่านคือกำลังใจในการพัฒนาของเรา' } },
    { path: 'order-status', component: InfoPageComponent, data: { title: 'Order Status', content: 'ติดตามสถานะคำสั่งซื้อของคุณได้ง่ายๆ เพียงกรอกหมายเลขคำสั่งซื้อและอีเมลของคุณในหน้านี้ คุณจะสามารถเห็นข้อมูลล่าสุดเกี่ยวกับการจัดส่งสินค้าของคุณ ตั้งแต่การยืนยันคำสั่งซื้อจนถึงสินค้าส่งถึงมือคุณ' } },
    { path: 'shipping', component: InfoPageComponent, data: { title: 'Shipping and Delivery', content: 'เรามีบริการจัดส่งที่รวดเร็วและเชื่อถือได้ทั่วประเทศ คำสั่งซื้อจะถูกจัดส่งภายใน 3-5 วันทำการสำหรับพื้นที่กรุงเทพฯ และปริมณฑล และ 5-7 วันทำการสำหรับพื้นที่อื่นๆ คุณสามารถตรวจสอบค่าจัดส่งและนโยบายเพิ่มเติมได้ที่นี่' } },
    { path: 'returns', component: InfoPageComponent, data: { title: 'Returns', content: 'ไม่พอใจในสินค้า? ไม่มีปัญหา! เรามีนโยบายการคืนสินค้าภายใน 30 วันนับจากวันที่ได้รับสินค้า สินค้าต้องอยู่ในสภาพสมบูรณ์พร้อมบรรจุภัณฑ์เดิม สามารถอ่านรายละเอียดและขั้นตอนการคืนสินค้าเพิ่มเติมได้ที่นี่' } },
    { path: 'payment-options', component: InfoPageComponent, data: { title: 'Payment Options', content: 'เรามีช่องทางการชำระเงินที่หลากหลายและปลอดภัยเพื่อความสะดวกของคุณ คุณสามารถชำระเงินผ่านบัตรเครดิต/เดบิต, การโอนเงินผ่านธนาคาร, หรือบริการชำระเงินออนไลน์ต่างๆ ทุกธุรกรรมได้รับการเข้ารหัสเพื่อความปลอดภัยสูงสุด' } },
    { path: 'contact-us', component: InfoPageComponent, data: { title: 'Contact Us', content: 'หากคุณมีคำถามหรือต้องการความช่วยเหลือเพิ่มเติม ทีมบริการลูกค้าของเราพร้อมให้บริการ! คุณสามารถติดต่อเราได้ผ่านทางอีเมล, โทรศัพท์, หรือ Live Chat ในเวลาทำการ จันทร์-ศุกร์ เวลา 9:00 - 18:00 น.' } },
    { path: 'news', component: InfoPageComponent, data: { title: 'News', content: 'ติดตามข่าวสารล่าสุดจาก Aura Run ได้ที่นี่! เราจะอัปเดตข้อมูลเกี่ยวกับผลิตภัณฑ์ใหม่, เทคโนโลยีล่าสุด, กิจกรรมพิเศษ, และเรื่องราวที่น่าสนใจจากชุมชนนักวิ่งของเรา' } },
    { path: 'careers', component: InfoPageComponent, data: { title: 'Careers', content: 'ร่วมเป็นส่วนหนึ่งของทีม Aura Run! เรากำลังมองหาผู้ที่มีความสามารถและหลงใหลในนวัตกรรมและวงการกีฬา หากคุณสนใจที่จะเติบโตไปพร้อมกับเรา สามารถดูตำแหน่งงานที่เปิดรับสมัครได้ที่นี่' } },
    { path: 'investors', component: InfoPageComponent, data: { title: 'Investors', content: 'สำหรับข้อมูลนักลงทุนสัมพันธ์, รายงานผลประกอบการ, และข่าวสารล่าสุดสำหรับผู้ถือหุ้น กรุณาเยี่ยมชมหน้าสำหรับนักลงทุนของเรา เรามุ่งมั่นที่จะสร้างการเติบโตที่ยั่งยืนและโปร่งใส' } },
    { path: 'sustainability', component: InfoPageComponent, data: { title: 'Sustainability', content: 'Aura Run มุ่งมั่นที่จะสร้างผลกระทบเชิงบวกต่อโลกใบนี้ เราให้ความสำคัญกับการใช้วัสดุรีไซเคิล, ลดการปล่อยก๊าซคาร์บอนไดออกไซด์ในกระบวนการผลิต, และสนับสนุนชุมชนอย่างยั่งยืน อ่านเพิ่มเติมเกี่ยวกับพันธกิจด้านความยั่งยืนของเราได้ที่นี่' } },
    { path: 'guides', component: InfoPageComponent, data: { title: 'Guides', content: 'Content for this page is under construction.' } },
    { path: 'terms-of-sale', component: InfoPageComponent, data: { title: 'Terms of Sale', content: 'Content for this page is under construction.' } },
    { path: 'terms-of-use', component: InfoPageComponent, data: { title: 'Terms of Use', content: 'Content for this page is under construction.' } },
    { path: 'privacy-policy', component: InfoPageComponent, data: { title: 'Privacy Policy', content: 'Content for this page is under construction.' } },
    
    { path: '**', redirectTo: '', pathMatch: 'full' }
];