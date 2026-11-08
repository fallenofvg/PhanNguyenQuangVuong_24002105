// components/TheSanPham.js
const TheSanPham = {
    name: 'TheSanPham',
    // Yêu cầu 2 & 3: Khai báo props, kiểu dữ liệu, prop bắt buộc và prop mặc định
    props: {
        ten: {
            type: String,
            required: true // Prop bắt buộc (Yêu cầu 3)
        },
        gia: {
            type: Number,
            required: true
        },
        anh: {
            type: String,
            default: 'https://via.placeholder.com/200' // Prop có giá trị mặc định (Yêu cầu 3)
        },
        moTa: {
            type: String,
            default: 'Chưa có mô tả cho sản phẩm này.'
        },
        soLuongTon: {
            type: Number,
            required: true
        }
    },
    // Yêu cầu 5 & 6: Dữ liệu riêng của từng component để ẩn/hiện mô tả độc lập
    data() {
        return {
            showDescription: false // Trạng thái ẩn/hiện mô tả
        }
    },
    methods: {
        toggleDescription() {
            this.showDescription = !this.showDescription;
        },
        buyProduct() {
            alert(`Bạn đã chọn mua: ${this.ten}`);
        }
    },
    template: `
        <div class="card">
            <div class="card-image">
                <img :src="anh" :alt="ten" />
                <!-- Yêu cầu 7: Nhãn riêng khi hết hàng -->
                <span v-if="soLuongTon === 0" class="badge-out">Hết hàng</span>
            </div>
            
            <div class="card-body">
                <h3>{{ ten }}</h3>
                <p class="price">Giá: {{ gia.toLocaleString() }} VNĐ</p>
                <p class="stock">Kho: {{ soLuongTon }} sản phẩm</p>

                <!-- Yêu cầu 5: Nút "Xem mô tả" -->
                <button class="btn-toggle" @click="toggleDescription">
                    {{ showDescription ? 'Ẩn mô tả' : 'Xem mô tả' }}
                </button>

                <!-- Phần hiển thị mô tả khi bật -->
                <div v-if="showDescription" class="description">
                    <p>{{ moTa }}</p>
                </div>

                <!-- Yêu cầu 7: Khóa nút "Mua" khi sản phẩm hết hàng -->
                <button 
                    class="btn-buy" 
                    :disabled="soLuongTon === 0" 
                    @click="buyProduct">
                    {{ soLuongTon > 0 ? 'Mua' : 'Hết hàng' }}
                </button>
            </div>
        </div>
    `
};

export default TheSanPham;