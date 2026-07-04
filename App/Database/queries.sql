use Library_System;

/* Query 1 */
select b.id, b.title, b.author_id, a.name
from books b join authors a on b.author_id = a.id;

/* Query 2 */
select b.id, b.title
from books b join category c on b.category_id = c.id
where c.name = 'Technology';

/* Query 3 */
select distinct b.id, b.title
from books b join borrow_records br on b.id = br.book_id;

/* Query 4*/
select b.id, b.title
from books b
where b.id not in (
    select br.book_id from borrow_records br
);

/* Query 5 */
select b.id, b.title
from books b join borrow_records br on b.id = br.book_id
group by b.id
order by count(*) desc
limit 5;

/* Query 6 */
select b.id, b.name
from borrowers b join borrow_records br on b.id = br.borrower_id
group by b.id
having count(*) > 3;

/* Query 7 */
select a.id, a.name
from books b join authors a on b.author_id = a.id
group by a.id
having count(*) > 5;

/* Query 8 */
select b.id, b.title, br.borrower_id, br.borrow_date, br.status
from books b join borrow_records br on b.id = br.book_id
where br.status = 'overdue';


/* Query 9 */
select c.id, c.name, count(*) as NoOfBooks
from category c join books b on c.id = b.category_id
group by c.id, c.name;

/* Query 10 */
select b.id, b.title
from borrow_records br join books b on br.book_id = b.id
order by br.id desc
limit 5;
