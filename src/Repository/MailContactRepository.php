<?php

namespace App\Repository;

use App\Entity\MailContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MailContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method MailContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method MailContact[]    findAll()
 * @method MailContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MailContact::class);
    }

    //fonction qui renvoie par order decroissant sur le chant date tous les message
    public function orderByAll(){
        $query = $this->createQueryBuilder('mail')
                 ->select('mail')
                 ->orderBy('mail.dateContacts', 'DESC');

        return $query->getQuery()->getResult(AbstractQuery::HYDRATE_OBJECT);
    }

    //fonction qui renvoie par order decroissant sur le chant date tous les message non repondu
    public function orderByWait(){
        $query = $this->createQueryBuilder('mail')
            ->select('mail')
            ->where('mail.reponse = 0')
            ->orderBy('mail.dateContacts', 'DESC');

        return $query->getQuery()->getResult(AbstractQuery::HYDRATE_OBJECT);
    }

    //fonction qui renvoie par order decroissant sur le chant date tous les message  repondu
    public function orderByReply(){
        $query = $this->createQueryBuilder('mail')
            ->select('mail')
            ->where('mail.reponse = 1')
            ->orderBy('mail.dateContacts', 'DESC');

        return $query->getQuery()->getResult(AbstractQuery::HYDRATE_OBJECT);
    }


}
