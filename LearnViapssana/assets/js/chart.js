document.addEventListener("DOMContentLoaded", function () {
    console.log("Chart.js โหลดแล้ว...");
    console.log("ข้อมูลบทเรียนจาก PHP:", lessonData);
    console.log("ข้อมูลบทฝึกปฏิบัติจาก PHP:", practiceData);

    let lessonCanvas = document.getElementById('testChart');
    let practiceCanvas = document.getElementById('practiceChart');

    // ❗ เช็คและสร้างกราฟบทเรียนถ้ามีข้อมูล
    if (lessonData && lessonData.length > 0 && lessonCanvas) {
        let lessonLabels = lessonData.map(row => row.lesson_title);
        let lessonPreScores = lessonData.map(row => row.avg_pre);
        let lessonPostScores = lessonData.map(row => row.avg_post);

        if (window.lessonChart instanceof Chart) {
            window.lessonChart.destroy();
            console.log("ทำลายกราฟบทเรียนเก่าแล้ว");
        }

        let lessonCtx = lessonCanvas.getContext('2d');
        window.lessonChart = new Chart(lessonCtx, {
            type: 'bar',
            data: {
                labels: lessonLabels,
                datasets: [
                    {
                        label: 'Pre-Test เฉลี่ย (บทเรียน)',
                        data: lessonPreScores,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Post-Test เฉลี่ย (บทเรียน)',
                        data: lessonPostScores,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        console.log("สร้างกราฟบทเรียนสำเร็จ");
    } else {
        console.warn("ไม่มีข้อมูลบทเรียน");
        if (lessonCanvas) lessonCanvas.style.display = "none";
    }

    // ❗ เช็คและสร้างกราฟฝึกปฏิบัติถ้ามีข้อมูล
    if (practiceData && practiceData.length > 0 && practiceCanvas) {
        let practiceLabels = practiceData.map(row => "บทฝึก " + row.practice_id);
        let practicePreScores = practiceData.map(row => row.avg_pre);
        let practicePostScores = practiceData.map(row => row.avg_post);

        if (window.practiceChart instanceof Chart) {
            window.practiceChart.destroy();
            console.log("ทำลายกราฟฝึกปฏิบัติเก่าแล้ว");
        }

        let practiceCtx = practiceCanvas.getContext('2d');
        window.practiceChart = new Chart(practiceCtx, {
            type: 'line',
            data: {
                labels: practiceLabels,
                datasets: [
                    {
                        label: 'Pre-Test เฉลี่ย (ฝึกปฏิบัติ)',
                        data: practicePreScores,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Post-Test เฉลี่ย (ฝึกปฏิบัติ)',
                        data: practicePostScores,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        console.log("สร้างกราฟฝึกปฏิบัติสำเร็จ");
    } else {
        console.warn("ไม่มีข้อมูลฝึกปฏิบัติ");
        if (practiceCanvas) practiceCanvas.style.display = "none";
    }
});
