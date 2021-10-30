# A web proxy that converts Collada (.dae extension file) to glTF format file.
A web proxy that converts Collada (.dae extension file) to glTF format file.

AR.js is sometimes used to display 3D objects in a web browser. However, the 3D data in Collada format (extension is .dae) cannot be used by AR.js. Instead, glTF format (extension is .glTF) can be used. It is possible to convert the data beforehand, but it is a time-consuming process. pf-ar2 is a web proxy that converts Collada to glTF. For example, the following access will return glTF data converted from foo.dae.

http://(your-ip-addr)/c2g.php?u=http://(some-domain)/path-to-file/foo.dae