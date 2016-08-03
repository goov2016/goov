git add .  
git commit -m "changes log"  
git push -u origin master  
下载代码
1.git pull
  如果远程分支和本地分支有冲突，会遇到Merge Conflict提示，然后要手动解决冲突。

2.git fetch
　git merge origin/ branch1
  fetch下载服务器代码到本地，但不自动合并。可以先git checkout origin/ branch1，切换到远程分支，看看代码修改情况，然后再决定是否merge。git pull = git fetch + git merge.

 3.git checkout branch1
  git merge branch2
  切换到branch1，然后将branch2上的代码merge到branch1上。
  
  
提交修改
1.从working directory提交到(暂存区)index
  git add a.c   (/  git add .)  
2.从index提交到本地repository
  git commit -m "modify a.c"　
3.从本地repository提交到远程repository
  git push origin branch1 (/   git push -u origin master) 