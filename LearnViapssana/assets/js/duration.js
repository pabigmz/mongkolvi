let youtubeApiKey = "api ของ Youtube"; // ตัวแปรเก็บ API Key

// โหลด API Key จาก config.php
fetch('./config.php')
  .then(response => response.json())
  .then(data => {
    console.log("API Key:", data.API_GOOGLE_YOUTUBE);
    youtubeApiKey = data.API_GOOGLE_YOUTUBE; // เก็บ API Key ไว้ใช้
    document.getElementById("api-key").innerText = youtubeApiKey;
  })
  .catch(error => console.error("Error loading API key:", error));

document.getElementById("videoLink").addEventListener("blur", async function() {
    const url = this.value;
    let videoId = '';
    let duration = 0;

    const youtubeMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/);
    
    if (youtubeMatch) {
        videoId = youtubeMatch[1];
        duration = await getYouTubeDuration(videoId);
    }

    console.log("Duration:", duration);
    document.getElementById("videoDuration").value = duration;

    // ถ้ามี duration ให้เปิดปุ่ม submit
    if (duration > 0) {
        document.getElementById("submitBtn").disabled = false;
        document.getElementById("submitBtn").textContent = "อัปโหลด";
    } else {
        alert("ไม่สามารถดึงข้อมูลของวิดีโอนี้ได้!");
    }
});

// ใช้ YouTube API ดึงความยาววิดีโอ
async function getYouTubeDuration(videoId) {
    if (!youtubeApiKey) {
        console.error("API Key ยังไม่ได้โหลด!");
        return 0;
    }

    const url = `https://www.googleapis.com/youtube/v3/videos?id=${videoId}&part=contentDetails&key=${youtubeApiKey}`;

    try {
        const response = await fetch(url);
        const data = await response.json();
        if (data.items.length > 0) {
            const duration = data.items[0].contentDetails.duration;
            return iso8601ToSeconds(duration);
        }
    } catch (error) {
        console.error("Error fetching YouTube duration:", error);
    }
    return 0;
}

// แปลง ISO 8601 duration เป็นวินาที
function iso8601ToSeconds(duration) {
    const match = duration.match(/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/);
    return (
        (parseInt(match[1]) || 0) * 3600 +
        (parseInt(match[2]) || 0) * 60 +
        (parseInt(match[3]) || 0)
    );
}
