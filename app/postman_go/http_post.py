import socket

def send_post_request():
    host = "localhost"
    port = 80
    resource = "/app/postman_go/add_user.php"

    # Define the form data

    name = input("Name: ")
    age = int(input("Age: "))
    email = input("Email: ")
    my_form: dict = {
        'name' : name,
        'age' : age,
        'email' : email
    }

    # form_data = f"name={my_form['name']}&age={my_form['age']}&email={my_form['email']}&Submit=Add"

    form_data = "name=ace32&age=22&email=m%40master.com"

    # Create the HTTP request with customized header
    # request=f"""POST {resource} HTTP/1.1\r\nHost: {host}\r\nConnection: keep-alive\r\nContent-Length: 36\r\nCache-Control: max-age=0\r\nsec-ch-ua: "Chromium";v="130", "Google Chrome";v="130", "Not?A_Brand";v="99"\r\nsec-ch-ua-mobile: ?0\r\nsec-ch-ua-platform: "Windows"\r\nOrigin: http://localhost\r\nDNT: 1\r\nUpgrade-Insecure-Requests: 1\r\nContent-Type: application/x-www-form-urlencoded\r\nUser-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7\r\nSec-Fetch-Site: same-origin\r\nSec-Fetch-Mode: navigate\r\nSec-Fetch-User: ?1\r\nSec-Fetch-Dest: document\r\nReferer: http://localhost/app/postman_go/add_user.php\r\nAccept-Encoding: gzip, deflate, br, zstd\r\nAccept-Language: en-US,en;q=0.9,fil;q=0.8\r\nCookie: PHPSESSID=ngl8q7odjrvtft3mshkmbrl4ht"""
    request = f"""POST {resource} HTTP/1.1\r\nHost: {host}\r\nConnection: keep-alive\r\nContent-Length: {len(form_data)}\r\nCache-Control: max-age=0\r\nOrigin: http://192.168.88.230\r\nDNT: 1\r\nUpgrade-Insecure-Requests: 1\r\nContent-Type: application/x-www-form-urlencoded\r\nUser-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7\r\nReferer: http://192.168.88.230/users/add.html\r\nAccept-Encoding: gzip, deflate\r\nAccept-Language: en-US,en;q=0.9,fil;q=0.8\r\nCustom-Header: Custom Value\r\n\r\n{form_data}"""

    # Connect to the server
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client_socket.connect((host, port))

    # Send the HTTP request
    client_socket.sendall(request.encode())

    # Receive the response
    response = b""
    while True:
        data = client_socket.recv(4096)
        if not data:
            break
        response += data

    # Close the connection
    client_socket.close()

    # Print the response
    print(response.decode())

if __name__ == "__main__":
    send_post_request()