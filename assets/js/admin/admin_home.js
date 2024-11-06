// Function to toggle the graph visibility
function toggleGraph() {
    const chart = document.getElementById('popularityGraph');
    const button = document.getElementById('toggleGraphBtn');
    
    if (chart.style.display === "none") {
        chart.style.display = "block";
        button.innerHTML = 'Show Graph <i id="toggleIcon" class="fas fa-caret-square-down"></i>';
    } else {
        chart.style.display = "none";
        button.innerHTML = 'Hide Graph <i id="toggleIcon" class="fas fa-caret-square-up"></i>';
    }
}

// Fetch average price data
fetch('graphs/fetch_average_price.php')
.then(response => response.json())
.then(data => {
    if (data.error) {
        console.error('Error:', data.error);
        return;
    }

    // Create the average price chart
    const ctx = document.getElementById('averagePriceChart').getContext('2d');
    const averagePrice = data.average_price;

    // Create the chart
    const averagePriceChart = new Chart(ctx, {
        type: 'bar', // You can change this to 'line' or 'pie' if you prefer
        data: {
            labels: ['Average Price'], // Label for the X-axis
            datasets: [{
                label: 'Average Price ($)',
                data: [averagePrice], // Data points for the chart
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Price ($)' // Y-axis title
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Metrics' // X-axis title
                    }
                }
            }
        }
    });
})
.catch(error => console.error('Error fetching average price data:', error));

// Fetch best-selling products data
fetch('graphs/fetch_best_sellers.php')
    .then(response => response.json())
    .then(data => {
        const labels = data.map(item => item.product_name);
        const sales = data.map(item => item.total_sold);

        const ctx = document.getElementById('bestSellersChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sold',
                    data: sales,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching best sellers data:', error));

// Fetch best-selling celebrity products data
fetch('graphs/fetch_best_celebrity.php') // Adjust the path to your PHP script
    .then(response => response.json())
    .then(data => {
        const labels = data.map(item => item.celebrity);
        const counts = data.map(item => item.total_sold);

        const ctx = document.getElementById('bestSellingChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sold',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Sold'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Celebrity'
                        }
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));

// Function to create a pie chart
function createPieChart(ctx, data, labels) {
    return new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    });
}

// Fetch the country purchases data from the server
document.addEventListener('DOMContentLoaded', () => {
    fetch('graphs/fetch_country_purchases.php')
        .then(response => response.json())
        .then(data => {
            const countries = data.map(item => item.country);
            const purchases = data.map(item => parseInt(item.total_purchases, 10));

            const ctx = document.getElementById('countryPurchasesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: countries,
                    datasets: [{
                        label: 'Total Purchases',
                        data: purchases,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});

// Fetch the feedback data from the server
fetch('graphs/fetch_feedback.php')
.then(response => response.json())
.then(feedbackData => {
    console.log(feedbackData); // Debugging: check if the data is correct

    // Create pie charts for each question
    createPieChart(document.getElementById('q1Chart'), Object.values(feedbackData.q1), Object.keys(feedbackData.q1));
    createPieChart(document.getElementById('q2Chart'), Object.values(feedbackData.q2), Object.keys(feedbackData.q2));
    createPieChart(document.getElementById('q3Chart'), Object.values(feedbackData.q3), Object.keys(feedbackData.q3));
    createPieChart(document.getElementById('q4Chart'), Object.values(feedbackData.q4), Object.keys(feedbackData.q4));
    createPieChart(document.getElementById('q5Chart'), Object.values(feedbackData.q5), Object.keys(feedbackData.q5));
    createPieChart(document.getElementById('q6Chart'), Object.values(feedbackData.q6), Object.keys(feedbackData.q6));
    createPieChart(document.getElementById('q7Chart'), Object.values(feedbackData.q7), Object.keys(feedbackData.q7));
    createPieChart(document.getElementById('q8Chart'), Object.values(feedbackData.q8), Object.keys(feedbackData.q8));
})
.catch(error => console.error('Error fetching feedback data:', error));

// Most Popular Celebrities
document.addEventListener('DOMContentLoaded', () => {
    fetch('graphs/fetch_popularity.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.hashtag);
            const counts = data.map(item => parseInt(item.popularity, 10)); // Convert popularity to integers

            const ctx = document.getElementById('popularityChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Popularity',
                        data: counts,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});

//Rooms with the Most Posts
document.addEventListener('DOMContentLoaded', () => {
    fetch('graphs/fetch_post_counts.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.room);
            const postCounts = data.map(item => parseInt(item.post_count, 10)); // Convert post count to integers

            const ctx = document.getElementById('postCountChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Posts',
                        data: postCounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});

//Most Like and Comment Posts
fetch('graphs/fetch_popular_posts.php') // Adjust the path to your PHP script
    .then(response => response.json())
    .then(data => {
        // Most Liked Posts
        const likedLabels = data.mostLikedPosts.map(post => post.post);
        const likedCounts = data.mostLikedPosts.map(post => post.post_likes);

        const ctxLiked = document.getElementById('likedPostsChart').getContext('2d');
        new Chart(ctxLiked, {
        type: 'bar',
            data: {
                labels: likedLabels,
                datasets: [{
                label: 'Likes',
                data: likedCounts,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Likes'
                        }
                    },
                    x: {
                    title: {
                        display: true,
                        text: 'Posts'
                            }
                        }
                    }
                }
            });

        // Most Commented Posts
        const commentedLabels = data.mostCommentedPosts.map(post => post.post);
        const commentedCounts = data.mostCommentedPosts.map(post => post.post_comments);

        const ctxCommented = document.getElementById('commentedPostsChart').getContext('2d');
        new Chart(ctxCommented, {
            type: 'bar',
                data: {
                    labels: commentedLabels,
                    datasets: [{
                        label: 'Comments',
                        data: commentedCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Comments'
                             }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Posts'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));


document.getElementById('generatePDFReportBtn').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'pt', 'a4');
    const pageHeight = pdf.internal.pageSize.height;
    const pageWidth = pdf.internal.pageSize.width;
            
    // Define margins for all sides (in points)
    const topMargin = 80; // Top margin
    const bottomMargin = 80; // Bottom margin
    const leftMargin = 60; // Left margin
    const rightMargin = 60; // Right margin
    let currentYPosition = topMargin; // Starting Y position for content
    let pageNumber = 1; // Page number tracker
            
    // Function to add a new page if content exceeds page height
    function checkPageLimit() {
        if (currentYPosition > pageHeight - bottomMargin) { // Leave some margin at the bottom
            pdf.addPage();
            currentYPosition = topMargin; // Reset Y position for the new page
            pageNumber++; // Increment the page number
            addPageNumber(); // Add page number to the new page
        }
    }
            
    // Function to add page number at the bottom of the page
    function addPageNumber() {
        pdf.setFontSize(10);
        pdf.setFont("helvetica", "normal");
        pdf.text(`${pageNumber}`, pageWidth - rightMargin, pageHeight - bottomMargin + 15, { align: "right" }); // Align to the right
    }
            
    // Function to capture canvas images and add to PDF
    function addCanvasToPDF(canvasId, width, height) {
        return new Promise((resolve) => {
        const canvas = document.getElementById(canvasId);
            if (canvas) {
                html2canvas(canvas).then((canvasImage) => {
                const imgData = canvasImage.toDataURL('image/png');
                checkPageLimit(); // Check if a new page is needed before adding image
                pdf.addImage(imgData, 'PNG', leftMargin, currentYPosition, width, height); // Use dynamic width and height
                currentYPosition += height + 20; // Adjust vertical space after each image
                resolve();
                });
            } else {
                resolve();
            }
        });
    }
            
    // Titles and subtitles with canvas IDs
    const sections = [
                    { title: 'Sales Statistic', subtitle: 'Average Price of Purchased Products', canvasId: 'averagePriceChart', width: 310, height: 180 },
                    { title: '', subtitle: 'Best-Selling Products', canvasId: 'bestSellersChart', width: 310, height: 180 },
                    { title: '', subtitle: 'Best-Selling Products by Celebrity', canvasId: 'bestSellingChart', width: 310, height: 180 },
                    { title: 'Customer Feedback Statistic', subtitle: 'Question 1: How satisfied are you with the overall shopping experience on KIVORIA?', canvasId: 'q1Chart', width: 200, height: 180 },
                    { title: '', subtitle: 'Question 2: How would you rate the variety of K-pop merchandise available?', canvasId: 'q2Chart', width: 200, height: 180 },
                    { title: '', subtitle: 'Question 3: Which categories of K-pop products do you frequently purchase?', canvasId: 'q3Chart', width: 200, height: 180 },
                    { title: '', subtitle: 'Question 4: How easy is it to navigate and find products on our website?', canvasId: 'q4Chart', width: 200, height: 180 },
                    { title: '', subtitle: 'Question 5: What payment method did you use for your most recent purchase? ', canvasId: 'q5Chart', width: 200, height: 180 },
                    { title: '', subtitle: 'Question 6: Did you face any issues during the checkout process?', canvasId: 'q6Chart', width: 200, height: 180 },
                    { title: '', subtitle: 'Question 7: Which feature do you find most useful on KIVORIA?', canvasId: 'q7Chart', width: 200, height: 180 },
                    { title: '', subtitle: 'Question 8: How likely are you to recommend KIVORIA to a friend?', canvasId: 'q8Chart', width: 200, height: 180 },
                    { title: 'Most Popular Celebrity', subtitle: 'Popularity of Celebrity Hashtags Based on User-Created Rooms', canvasId: 'popularityChart', width: 280, height: 150 },
                    { title: '', subtitle: 'Most Liked Posts', canvasId: 'likedPostsChart', width: 360, height: 210 },
                    { title: '', subtitle: 'Most Commented Posts', canvasId: 'commentedPostsChart', width: 370, height: 210 },
    ];
            
    // Function to generate the PDF report
    async function generateReport() {
        // Title Page
        pdf.setFontSize(40); // Font size for main title
        pdf.setFont("helvetica", "bold");
        pdf.text("KIVORIA Report", pageWidth / 2, pageHeight / 2 - 50, { align: "center" });
    
        pdf.setFontSize(18); // Font size for subtitle
        pdf.setFont("helvetica", "italic");
        pdf.text("Created by Zi Hao", pageWidth / 2, pageHeight / 2, { align: "center" });
    
        pdf.setFontSize(12); // Font size for date
        pdf.setFont("helvetica", "normal");
        pdf.text(`Date: ${new Date().toLocaleDateString()}`, pageWidth / 2, pageHeight / 2 + 50, { align: "center" });
    
        pdf.addPage(); // Add a new page after the title page
        currentYPosition = topMargin; // Reset Y position for the content on the new page
    
        addPageNumber(); // Add page number on the new page (Page 1 after title page)
    
        for (let section of sections) {
            checkPageLimit(); // Check if a new page is needed before each section
            
            // Add title
            pdf.setFontSize(16); // Font size for title (h3)
            pdf.setFont("helvetica", "bold");
            pdf.text(section.title, leftMargin, currentYPosition);
            currentYPosition += 20;
            
            // Add subtitle if present
            if (section.subtitle) {
                pdf.setFontSize(12); // Font size for subtitle (h6)
                pdf.setFont("helvetica", "normal");
                pdf.text(section.subtitle, leftMargin, currentYPosition);
                currentYPosition += 20;
            }
            
            // Add the graph (canvas image) below the title/subtitle
            await addCanvasToPDF(section.canvasId, section.width, section.height);
        }
            
        // Save the PDF
        pdf.save('KIVORIA_Report.pdf');
    }
            
addPageNumber(); // Add page number to the first page
generateReport();
});
            