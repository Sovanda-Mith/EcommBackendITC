import {
  Args,
  Mutation,
  Query,
  Resolver,
  ResolveField,
  Parent,
} from '@nestjs/graphql';
import { AttendanceStatus } from './attendance-status.enum';

@Resolver('Attendance')
export class AttendanceResolver {
  private attendances = [
    {
      session: 'A',
      status: AttendanceStatus.A,
      studentId: 1,
      marker: 'Sok',
    },
    {
      session: 'B',
      status: AttendanceStatus.P,
      studentId: 2,
      marker: 'Sok',
    },
    {
      session: 'C',
      status: AttendanceStatus.L,
      studentId: 3,
      marker: 'Sok',
    },
  ];

  private students = [
    { id: 1, name: 'Dara', idCard: 'S123', className: 'A' },
    { id: 2, name: 'Sok', idCard: 'S124', className: 'A' },
    { id: 3, name: 'Chan', idCard: 'S125', className: 'B' },
  ];

  @Query('attendances')
  getAttendances() {
    return this.attendances;
  }

  @Mutation('markStudentAttendance')
  markStudentAttendance(
    @Args('session') session: string,
    @Args('status') status: AttendanceStatus,
    @Args('studentId') studentId: number,
    @Args('marker') marker: string,
  ) {
    const newAttendance = {
      session,
      status,
      studentId,
      marker,
    };

    this.attendances.push(newAttendance);
    return newAttendance;
  }

  @Mutation('countAttendanceByClassName')
  countAttendanceByClassName(@Args('className') className: string) {
    const count = this.attendances.filter((attendance) => {
      const student = this.students.find((s) => s.id === attendance.studentId);
      return student?.className === className;
    }).length;
    return count;
  }

  @Mutation('removeAttendance')
  removeAttendance(
    @Args('session') session: string,
    @Args('studentId') studentId: number,
  ) {
    const originalLength = this.attendances.length;
    this.attendances = this.attendances.filter(
      (a) => !(a.session === session && a.studentId === studentId),
    );
    return this.attendances.length < originalLength; // true if removed
  }

  @Mutation('countAttendanceByStudentId')
  countAttendanceByStudentId(@Args('studentId') studentId: number) {
    const count = this.attendances.filter(
      (attendance) => attendance.studentId === studentId,
    ).length;
    return count;
  }
}
