git add .  
git commit -m "changes log"  
git push -u origin master  
���ش���
1.git pull
  ���Զ�̷�֧�ͱ��ط�֧�г�ͻ��������Merge Conflict��ʾ��Ȼ��Ҫ�ֶ������ͻ��

2.git fetch
��git merge origin/ branch1
  fetch���ط��������뵽���أ������Զ��ϲ���������git checkout origin/ branch1���л���Զ�̷�֧�����������޸������Ȼ���پ����Ƿ�merge��git pull = git fetch + git merge.

 3.git checkout branch1
  git merge branch2
  �л���branch1��Ȼ��branch2�ϵĴ���merge��branch1�ϡ�
  
  
�ύ�޸�
1.��working directory�ύ��(�ݴ���)index
  git add a.c   (/  git add .)  
2.��index�ύ������repository
  git commit -m "modify a.c"��
3.�ӱ���repository�ύ��Զ��repository
  git push origin branch1 (/   git push -u origin master) 