<?php 
    require 'connection.php';

    function query($sql) {
        global $con;
        $result = mysqli_query($con, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function insertCategory($data){ 
        global $con;

        $name = $data['name'];
        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        mysqli_query($con, "INSERT INTO categories  (name, createAt) VALUES ('$name', '$date')");

        // mengembalikan data yang berhasil ditambahkan atau tidak
        return mysqli_affected_rows($con);
    }

    function updateCategory($data, $key) {
        global $con;

        $id = $key;
        $name = $data['name'];
        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        $result = mysqli_query($con, "UPDATE categories SET name = '$name', createAt = '$date' WHERE id = '$id'");

        return mysqli_affected_rows($con);
    }

    function deleteCategory($id) {
        global $con;

        mysqli_query($con, "DELETE FROM categories WHERE id = '$id'");
        
        return mysqli_affected_rows($con);
    }

    function searchCategory($key) {
        $search = "SELECT * FROM categories WHERE
                    category_name LIKE '%$key%'
                ";
        return query($search); 
    }

    function insertProduct($data) {
        global $con;

        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $stock = $data['stock'];
        
        // upload gambar
        $gambar = upload();

        // kalo gagal insert gak jalan
        if (!$gambar) {
            return false;
        } 
        
        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        $product = mysqli_query($con, "INSERT INTO product (name, description, price, stock, createAt) VALUES ('$name', '$description', '$price', '$stock', '$date')");
        $id_product = mysqli_insert_id($con);
        
        $product .= mysqli_query($con, "INSERT INTO product_galleries (product_id, image) VALUES ('$id_product', '$gambar')");

        return mysqli_affected_rows($con);
    }

    function upload() {
            $namaFile = $_FILES['gambar']['name'];
            $ukuranFile = $_FILES['gambar']['size'];
            $error = $_FILES['gambar']['error'];
            $tmpName = $_FILES['gambar']['tmp_name'];
        
            // cek apakah tidak ada gambar yang diupload
            if($error === 4) {
                echo "
                        <script>
                            alert('Pilih gambar terlebih dahulu!');
                        </script>;
                    ";
                return false;
            }

            // cek ekstensi gambar atau bukan
            $validasi = ['jpg', 'jpeg', 'png'];
            $ekstensiGambar = pathinfo($namaFile, PATHINFO_EXTENSION);

            if (!in_array($ekstensiGambar, $validasi)) {
                echo "
                        <script>
                            alert('Yang diupload bukan gambar!');
                        </script>;
                    ";
            }

            // cek ukuran file
            if ($ukuranFile > (10 * 1024 * 1024)) {
                echo "
                        <script>
                            alert('Ukuran gambar terlalu besar!');
                        </script>;
                    ";
            }

            // generate nama gambar baru
            $namaFileBaru = uniqid();
            $namaFileBaru .= '.';
            $namaFileBaru .= $ekstensiGambar;

            // upload gambar
            $target = '../../../assets/' .$namaFileBaru;
            move_uploaded_file($tmpName, $target);
            
            $query = query("SELECT id FROM product");
        
            return $namaFileBaru;
        
    }

    function updateProduct($data, $id) {
        global $con;

        // ambil data pada form
        $admin_id = $_SESSION['id'];
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $stock = $data['stock'];
        $gambarLama = $data['gambarLama'];

        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        // cek apakah user pilih gambar baru atau tidak
        if ($_FILES["gambar"]["error"] === 4) {
            $gambar = $gambarLama;
        } else {
            $gambar = upload();
        }
        
        $query = mysqli_query($con, "UPDATE product INNER JOIN product_galleries 
                                    ON product_galleries.product_id = product.id
                                    SET product.name = '$name',
                                    product.description = '$description',
                                    product.price = '$price',
                                    product.stock = '$stock',
                                    product.createAt = '$date',
                                    product_galleries.image = '$gambar'
                                    WHERE product.id = '$id';
                                    ");

        return mysqli_affected_rows($con);
    }

    function deleteProduct($id) {
        global $con;
        
        mysqli_query($con, "DELETE FROM product_galleries WHERE product_id = $id");
        mysqli_query($con, "DELETE FROM product WHERE id = $id");

        return mysqli_affected_rows($con);
    }

    function checkout($data) {
        global $con;

        $customer_id = $_SESSION['id'];        
        $address = $data['address'];
        $payment_id = 1;
        $cart_id = $data['transaction_id'];
        $amount = $data['amount'];
        $product_id = $data['product_id'];
        $total_price = $data['total_price'];

        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        $updateData = mysqli_query($con, "UPDATE customer SET address = '$address' WHERE id = '$customer_id'");

        $checkout = mysqli_query($con, "INSERT INTO checkout (customer_id, cart_id, payment_id, status, total_price, createAt) VALUES ('$customer_id', '$cart_id', '$payment_id', 'Sudah Dibayar', '$total_price', '$date')");

        // delete cart
        $delete = mysqli_query($con, "DELETE FROM cart");
        
        // update stok
        $updateStock = mysqli_query($con, "UPDATE product SET stock = stock - '$amount' WHERE id = '$product_id'");

        // mengembalikan data yang berhasil ditambahkan atau tidak
        return mysqli_affected_rows($con);
    }

    function report($data) {
        global $con;

        $customer_id = $_SESSION['id'];
        $message = $data['message'];

        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        mysqli_query($con, "INSERT INTO report VALUES ('', '$customer_id', '$message', '$date')");
        
        return mysqli_affected_rows($con);
    }
?>