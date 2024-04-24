<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            "name" => "Lập Trình Website",
            "summary" => "Khoá học lập trình dành cho đối tượng dưới 18 tuổi",
            "image" => "86de25bf5b2b497bb8be816e43e60bc0.jpg",
            "discount" => "20",
            "Grade" => "K20GD-01",
            "detail" => "
            Khoá học lập trình dành cho đối tượng dưới 18 tuổi tập trung vào việc giới thiệu và phát triển kỹ năng lập trình cơ bản. Học viên sẽ bắt đầu với các khái niệm cơ bản như biến, điều kiện, và vòng lặp, sau đó chuyển sang các khái niệm nâng cao như hàm, mảng, và đối tượng.
            Khoá học này sử dụng phương pháp giảng dạy linh hoạt và thú vị, tập trung vào việc áp dụng lý thuyết vào các dự án thực tế. Học viên sẽ có cơ hội thực hành thông qua các bài tập và dự án lập trình, từ đó xây dựng khả năng giải quyết vấn đề và logic lập trình.
            Đồng thời, khoá học cũng nhấn mạnh việc phát triển kỹ năng làm việc nhóm và giao tiếp, tạo cơ hội cho học viên thảo luận, chia sẻ kinh nghiệm và hỗ trợ lẫn nhau trong quá trình học.
            Kết thúc khoá học, học viên sẽ có kiến thức cơ bản vững về lập trình và sẵn sàng để tham gia vào các dự án phức tạp hơn trong tương lai.",
            "created_at" => now(),
            "updated_at" => now(),
            "course_cate_id" => "1",
        ]);
    }
}
