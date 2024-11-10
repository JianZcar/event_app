<?php
include './../../proj_info.php';

function paginate_init($records) { 
	/**
	 * Initializes pagination links.
	 *
	 * @param array $records Pagination data with 'total_pages' key.
	 *
	 * @example
	 * $records = [
	 *     'total_pages' => 10,
	 * ];
	 * paginate_init($records);
	 */
?>
	<a class="paginate-btn" href="?page=1">First</a>

	<!-- <?php // if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 1): ?>
			<a class="paginate-btn" href="?page=<?php echo $_GET['page'] - 1; ?>">Prev</a>
	<?php // else: ?>
			<a class="paginate-btn" href="">Prev</a>
	<?php // endif; ?> -->

	<div class="hidden md:block page-numbers">
			<?php
			$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$totalPages = $records['total_pages'];
			$range = 2; // Number of pages to show before and after the current page

			$startPage = max(1, $currentPage - $range);
			$endPage = min($totalPages, $currentPage + $range);

			for ($i = $startPage; $i <= $endPage; $i++) : ?>
					<a class="paginate-btn" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php endfor; ?>
	</div>

	<?php if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] < $records['total_pages']): ?>
			<a class="paginate-btn" href="?page=<?php echo $_GET['page'] + 1; ?>">Next</a>
	<?php else: ?>
			<a class="paginate-btn" href="">Next</a>
	<?php endif; ?>

	<a class="paginate-btn" href="?page=<?php echo $records[1]; ?>">Last</a>
	<?php
}
?>

<?php
function paginate($conn, $sql, $start, $limit) {
	/**
	 * Paginate database query results
	 *
	 * @param object $conn  Database connection
	 * @param string $sql   SQL query command
	 * @param int    $start Starting point of pagination (optional)
	 * @param int    $limit Limit of pagination (optional)
	 *
	 * @return array Paginated records and metadata
	 */
	if (isset($_GET['page']) && is_numeric($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	// Calculate the starting point
	$start_point = ($page - 1) * $limit;

  	// Prepare the query before limiting but first calculate the total of rows
	$records = $conn->query($sql);
	$nr_rows = $records->num_rows;

	// Calculate the total of pages
	$pages = ceil($nr_rows / $limit);

  	// PREPARE THE QUERY WITH LIMIT
  	// first remove the ; if there's available
	if (substr($sql, -1) == ";") {
		$sql = substr($sql, 0, -1);
	}
	$sql .= " LIMIT $start_point, $limit;";

  	// Execute the query
	$records = $conn->query($sql);

  	// Return the result
	return array(
		'records' => $records,
		'total_pages' => $pages,
		'current_page' => $page);
}
?>