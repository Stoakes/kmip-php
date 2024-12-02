Code Generator reads a KMIP json spec and generates the PHP files for every Enum, Mask & Tag described in the spec.

It thus brings consistency to the building blocks of the KMIP library.

There's probably no need to run it again, because generated PHP files are commited to the repository.

Anyway, you can run it with: `php generator.php  -i ../spec/kmip_2_0.json -o ../src`
