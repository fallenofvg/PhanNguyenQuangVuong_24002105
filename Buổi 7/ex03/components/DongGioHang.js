// components/DongGioHang.js
const DongGioHang = {
    name: 'DongGioHang',
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    // Yêu cầu 3: Khai báo các sự kiện tùy chỉnh (emits)
    emits: ['doi-so-luong', 'yeu-cau-xoa'],
    computed: {
        // Yêu cầu 2: Thành tiền = Đơn giá * Số lượng
        thanhTien() {
            return this.item.donGia * this.item.soLuong;
        }
    },
    methods: {
        // Yêu cầu 3 & 6: Không sửa trực tiếp prop, chỉ phát sự kiện kèm dữ liệu mới
        tangSoLuong() {
            if (this.item.soLuong < 99) {
                this.$emit('doi-so-luong', this.item.id, this.item.soLuong + 1);
            }
        },
        giamSoLuong() {
            if (this.item.soLuong > 1) {
                this.$emit('doi-so-luong', this.item.id, this.item.soLuong - 1);
            }
        },
        xoaItem() {
            this.$emit('yeu-cau-xoa', this.item.id);
        }
    },
    template: `
        <tr>
            <td>{{ item.ten }}</td>
            <td>{{ item.donGia.toLocaleString() }} đ</td>
            <td style="text-align: center;">
                <button @click="giamSoLuong" :disabled="item.soLuong <= 1">-</button>
                <span style="margin: 0 10px; font-weight: bold;">{{ item.soLuong }}</span>
                <button @click="tangSoLuong" :disabled="item.soLuong >= 99">+</button>
            </td>
            <td>{{ thanhTien.toLocaleString() }} đ</td>
            <td>
                <button @click="xoaItem" style="color: red; cursor: pointer;">Xóa</button>
            </td>
        </tr>
    `
};

export default DongGioHang;