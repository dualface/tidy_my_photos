# 整理我的照片分为三个步骤，可以根据需要使用：1. 将照片按照创建时间移动到分组目录中2. 计算所有照片的 Hash 码3. 根据 Hash 码删除重复照片### 将照片归档~~~$ php move_all.php -s 照片所在目录 -o 归档目录~~~所有照片会按照照片文件创建日期，归档到 “年/月” 目录中，并且以创建日期和时间重命名照片。例如：~~~Photos/2015/08/PHOTO-2015-08-15-084228.jpg~~~### 计算所有照片的 Hash~~~$ php calc_hash.php -s 归档目录 -o hash数据写入目录~~~程序会计算所有照片文件的 MD5 码，然后写入到指定目录中的 `hash.json` 文件。### 移除重复照片~~~$ php remove_duplicate.php~~~会读取当前目录下的 `hash.json` 文件，然后根据 Hash 码删除重复照片。