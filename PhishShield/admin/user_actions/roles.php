<?php

$query = "SELECT * FROM roles WHERE id != 1";
$stmt = $conn->prepare($query);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $key => $value) {
?>
        <option value="<?php echo $value['id'] ?>"><?php echo $value['role_name'] ?></option>
<?php
    }
} catch (PDOException $error) {
    // echo 'Something went wrong';
}
